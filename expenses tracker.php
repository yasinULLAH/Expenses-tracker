<?php
// Define the CSV file path
$csvFile = 'expenses.csv';

// Function to initialize the CSV file with headers if it doesn't exist
function initializeCSV($csvFile) {
    if (!file_exists($csvFile)) {
        $headers = ['ID', 'Date', 'Category', 'Amount', 'Description'];
        $file = fopen($csvFile, 'w');
        fputcsv($file, $headers);
        fclose($file);
    }
}

// Function to read all expenses from the CSV file
function readExpenses($csvFile) {
    $expenses = [];
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ',');
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $expense = array_combine($headers, $data);
            $expenses[] = $expense;
        }
        fclose($handle);
    }
    return $expenses;
}

// Function to add a new expense to the CSV file
function addExpense($csvFile, $date, $category, $amount, $description) {
    $id = time();
    $file = fopen($csvFile, 'a');
    fputcsv($file, [$id, $date, $category, $amount, $description]);
    fclose($file);
}

// Function to delete an expense by ID
function deleteExpense($csvFile, $deleteId) {
    $expenses = readExpenses($csvFile);
    $file = fopen($csvFile, 'w');
    $headers = ['ID', 'Date', 'Category', 'Amount', 'Description'];
    fputcsv($file, $headers);
    foreach ($expenses as $expense) {
        if ($expense['ID'] != $deleteId) {
            fputcsv($file, [$expense['ID'], $expense['Date'], $expense['Category'], $expense['Amount'], $expense['Description']]);
        }
    }
    fclose($file);
}

// Function to export expenses as CSV
function exportCSV($csvFile) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="expenses_export.csv"');
    readfile($csvFile);
    exit();
}

// Initialize CSV file
initializeCSV($csvFile);

// Handle Add Expense
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expense'])) {
    $date = $_POST['date'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    addExpense($csvFile, $date, $category, $amount, $description);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete Expense
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    deleteExpense($csvFile, $deleteId);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Export CSV
if (isset($_GET['export'])) {
    exportCSV($csvFile);
}

// Read all expenses
$expenses = readExpenses($csvFile);

// Handle Filters
$filteredExpenses = $expenses;
$filterCategory = '';
$filterMonth = '';

if (isset($_GET['filter_category']) && $_GET['filter_category'] != '') {
    $filterCategory = $_GET['filter_category'];
    $filteredExpenses = array_filter($filteredExpenses, function($expense) use ($filterCategory) {
        return $expense['Category'] === $filterCategory;
    });
}

if (isset($_GET['filter_month']) && $_GET['filter_month'] != '') {
    $filterMonth = $_GET['filter_month'];
    $filteredExpenses = array_filter($filteredExpenses, function($expense) use ($filterMonth) {
        return date('Y-m', strtotime($expense['Date'])) === $filterMonth;
    });
}

// Get unique categories
$categories = array_unique(array_map(function($expense) {
    return $expense['Category'];
}, $expenses));
sort($categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        /* Container */
        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        /* Heading */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styling */
        .expense-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .expense-form input, .expense-form select, .expense-form textarea, .expense-form button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .expense-form input, .expense-form select {
            flex: 1 1 200px;
        }

        .expense-form textarea {
            flex: 1 1 100%;
            resize: vertical;
            height: 80px;
        }

        .expense-form button {
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            flex: 1 1 100px;
        }

        .expense-form button:hover {
            background: #218838;
        }

        /* Filters */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filters select, .filters button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .filters button {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .filters button:hover {
            background: #0056b3;
        }

        /* Expense Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background: #f8f9fa;
        }

        table tr:nth-child(even) {
            background: #f2f2f2;
        }

        /* Export Button */
        .export-btn {
            padding: 10px 20px;
            background: #ffc107;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .export-btn:hover {
            background: #e0a800;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .expense-form {
                flex-direction: column;
            }

            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Expense Tracker</h1>
        <form class="expense-form" method="POST" action="">
            <input type="date" name="date" required>
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Food">Food</option>
                <option value="Transport">Transport</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Utilities">Utilities</option>
                <option value="Health">Health</option>
                <option value="Other">Other</option>
            </select>
            <input type="number" name="amount" placeholder="Amount" step="0.01" min="0" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit" name="add_expense">Add Expense</button>
        </form>

        <div class="filters">
            <select id="filter_category" onchange="applyFilters()">
                <option value="">All Categories</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php if($filterCategory === $cat) echo 'selected'; ?>><?php echo htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="month" id="filter_month" value="<?php echo htmlspecialchars($filterMonth); ?>" onchange="applyFilters()">
            <button onclick="window.location.href='?export=true'">Export as CSV</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount ($)</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($filteredExpenses) > 0): ?>
                    <?php foreach($filteredExpenses as $expense): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($expense['Date']); ?></td>
                            <td><?php echo htmlspecialchars($expense['Category']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($expense['Amount'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($expense['Description']); ?></td>
                            <td><a href="?delete_id=<?php echo htmlspecialchars($expense['ID']); ?>" onclick="return confirm('Are you sure you want to delete this expense?');">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No expenses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button class="export-btn" onclick="window.location.href='?export=true'">Export Expenses as CSV</button>
    </div>

    <script>
        function applyFilters() {
            const category = document.getElementById('filter_category').value;
            const month = document.getElementById('filter_month').value;
            let query = '';

            if(category) {
                query += 'filter_category=' + encodeURIComponent(category) + '&';
            }

            if(month) {
                query += 'filter_month=' + encodeURIComponent(month) + '&';
            }

            // Remove trailing &
            if(query.endsWith('&')) {
                query = query.slice(0, -1);
            }

            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>' + (query ? '?' + query : '');
        }
    </script>
</body>
</html>
