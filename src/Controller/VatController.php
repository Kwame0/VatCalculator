<?php

namespace App\Controller;

use App\Entity\VatCalculation;
use App\Repository\VatCalculationRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



class VatController extends AbstractController
{
    /**
     * @Route("/", name="app_vat")
     */
    public function index(): Response
    {
        return $this->render('vat/index.html.twig', [
            'controller_name' => 'VatController',
        ]);
    }

    /**
     * @Route("/api/calculate-vat", name="calculate_vat", methods={"POST"})
     */
    public function calculateVat(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // The method retrieves user-provided monetary value V and VAT percentage rate R from the request and converts them to float values.
        $value = floatval($request->request->get('value'));
        $rate = floatval($request->request->get('rate'));
        // The isInclusive variable is set to true if the VAT is inclusive and false otherwise.
        $isInclusive = $request->request->get('isInclusive') === "true";
        // The VAT rate is calculated by dividing R by 100.
        $vatRate = $rate / 100;
        /*If isInclusive is true, the method calculates the VAT amount by multiplying V by the VAT rate and dividing the result by (1 + VAT rate). Then, it calculates the value excluding VAT by subtracting the VAT amount from V. The value including VAT is just the original value V.*/
        if ($isInclusive) {
            $vatAmount = $value * $vatRate / (1 + $vatRate);
            $valueExVat = $value - $vatAmount;
            $valueIncVat = $value;
        } else {
            /*If isInclusive is false, the method calculates the VAT amount by multiplying V by the VAT rate. The value excluding VAT is the original value V. The value including VAT is calculated by adding the VAT amount to V.*/
            $vatAmount = $value * $vatRate;
            $valueExVat = $value;
            $valueIncVat = $value + $vatAmount;
        }

        // Create a new VatCalculation entity and persist it
        $vatCalculation = new VatCalculation(
            $value,
            $rate,
            $isInclusive,
            $valueExVat,
            $valueIncVat,
            $vatAmount
        );

        // could also use the following
        // $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($vatCalculation);
        $entityManager->flush();
        // The calculated values are returned as a JSON response.
        return new JsonResponse([
            'valueExVat' => $valueExVat,
            'valueIncVat' => $valueIncVat,
            'vatAmount' => $vatAmount,
        ]);
    }

        /**
     * @Route("/api/vat-history", name="vat_history", methods={"GET"})
     */
    public function getVatHistory(VatCalculationRepository $vatCalculationRepository): JsonResponse
    {
        $vatHistory = $vatCalculationRepository->findAll();

        $vatHistoryArray = array_map(function (VatCalculation $vatCalculation) {
            return [
                'id' => $vatCalculation->getId(),
                'value' => $vatCalculation->getValue(),
                'rate' => $vatCalculation->getRate(),
                'isInclusive' => $vatCalculation->getIsInclusive(),
                'valueExVat' => $vatCalculation->getValueExVat(),
                'valueIncVat' => $vatCalculation->getValueIncVat(),
                'vatAmount' => $vatCalculation->getVatAmount(),
                'createdAt' => $vatCalculation->getCreatedAt()->format('Y-m-d H:i:s'), // we could of also saved this as a unix timestamp in the DB
            ];
        }, $vatHistory);

        return new JsonResponse($vatHistoryArray);
    }

    /**
     * @Route("/api/clear-history", name="clear_history", methods={"POST"})
     */
    public function clearHistory(EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager
            ->createQuery('DELETE FROM App\Entity\VatCalculation')
            ->execute();

        return new JsonResponse(['message' => 'VAT history cleared']);
    }


}
