# VAT Calculator

A simple VAT Calculator built using Symfony and Tailwind CSS. The application allows users to enter a monetary value (V) and a VAT percentage rate (R), then calculates and displays the VAT amounts for both inclusive and exclusive scenarios. The results are stored in a history table, which can be cleared or exported as a CSV file.

## Features

- Calculate VAT for both inclusive and exclusive scenarios
- Store and display a history of calculations
- Clear the history table
- Export the history table as a CSV file

## Installation

1. Clone the repository:

```git clone https://github.com/yourusername/vat-calculator.git```

2. Install the dependencies:

```composer install```

3. Configure your database connection in the `.env` file:

```DATABASE_URL="mysql://db_user:db_password@localhost:3306/db_name"```

4. Create the database and tables:

```bin/console doctrine:database:create```<br>
```bin/console doctrine:migrations:migrate```


5. Start the Symfony server:

```symfony server:start```

6. Open your browser and navigate to [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Usage

Enter a monetary value (V) and a VAT percentage rate (R). Choose whether the value is inclusive or exclusive of VAT, then click the "Calculate" button to perform the calculation. The results will be displayed in a table, and the history of calculations can be viewed, cleared, or exported as a CSV file.

## License

This project is licensed under the MIT License.
