<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the Excel file
$excelFile = './countries.XLSX'; // Change this to your Excel file path
$spreadsheet = IOFactory::load($excelFile);

// Select the first worksheet
$worksheet = $spreadsheet->getActiveSheet();

// Get the highest row and column numbers
$highestRow = $worksheet->getHighestRow();
$highestColumn = $worksheet->getHighestColumn();

// Initialize an empty array to store data
$data = [];

// Get the column names as attributes
$columnNames = [];
for ($col = 'A'; $col <= $highestColumn; $col++) {
    $columnNames[] = $worksheet->getCell($col . '1')->getValue();
}

// Iterate over rows starting from the second row (since the first row contains column names)
for ($row = 2; $row <= $highestRow; $row++) {
    $rowData = [];
    // Iterate over columns
    for ($col = 'A'; $col <= $highestColumn; $col++) {
        // Use column names as attribute names
        $columnName = $columnNames[ord($col) - 65]; // Convert column letter to array index
        $cellValue = $worksheet->getCell($col . $row)->getValue();
        $rowData[$columnName] = $cellValue;
    }
    $data[] = $rowData;
}

// Convert array to JSON
$jsonData = json_encode($data, JSON_PRETTY_PRINT);

// Write JSON to file
$outputFile = 'countries.json';
file_put_contents($outputFile, $jsonData);

echo "JSON data has been saved to $outputFile". PHP_EOL;
?>