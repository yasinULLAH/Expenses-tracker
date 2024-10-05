# Expense Tracker

The **Expense Tracker** is a lightweight web application designed to help users manage and monitor their personal expenses. Built using **PHP**, **JavaScript**, **HTML**, and **CSS**, this app leverages a simple CSV file as its local database, making it easy to set up and use without the need for complex database configurations. Whether you're looking to keep track of daily expenses, categorize your spending, or generate reports, this Expense Tracker provides a straightforward solution.

## Project Link
[Expense Tracker GitHub Repository](https://github.com/yasinULLAH/Expenses-tracker/tree/main)

## Features
- **Add Expenses**: Input your expenses with details such as date, category, amount, and description.
- **View Expenses**: Display a comprehensive list of all recorded expenses in a clean and organized table.
- **Filter Expenses**: Easily filter expenses by category or month to analyze your spending patterns.
- **Delete Expenses**: Remove any expense entries that are no longer needed.
- **Export as CSV**: Download your expenses as a CSV file for external use or backup purposes.
- **Data Persistence**: All expense data is stored locally in a CSV file (`expenses.csv`), ensuring your data is retained between sessions without the need for a database.

## Technologies Used
- **PHP**: Handles server-side operations such as reading from and writing to the CSV file, managing form submissions, and processing data.
- **JavaScript**: Enhances user interactivity by managing filters and dynamic page updates.
- **HTML**: Structures the web application's content.
- **CSS**: Styles the application for a modern and responsive user interface.

## Installation & Usage

### Prerequisites
- A web server with PHP support (e.g., [XAMPP](https://www.apachefriends.org/index.html), [MAMP](https://www.mamp.info/en/), or a live server with PHP enabled).

### Steps to Run Locally

1. **Clone the Repository:**
    ```bash
    git clone https://github.com/yasinULLAH/Expenses-tracker.git
    ```
2. **Navigate to the Project Folder:**
    ```bash
    cd Expenses-tracker
    ```
3. **Ensure CSV File Exists:**
    - The application uses a `expenses.csv` file to store expense data.
    - If the file doesn't exist, it will be created automatically when you add your first expense.
    - Make sure the web server has write permissions to the project directory to allow PHP to create and modify the CSV file.

4. **Start Your Web Server:**
    - If using XAMPP, place the project folder inside the `htdocs` directory and start Apache.
    - Access the application by navigating to `http://localhost/Expenses-tracker` in your web browser.

5. **Open in Browser:**
    - You can simply navigate to the project's URL to start using the Expense Tracker.

### Usage

1. **Add a New Expense:**
    - Fill out the **Date**, **Category**, **Amount**, and **Description** fields in the expense form.
    - Click the **"Add Expense"** button to save the entry.

2. **View Expenses:**
    - All added expenses will appear in the table below the form.
    - The table displays the date, category, amount, description, and an option to delete the expense.

3. **Filter Expenses:**
    - Use the **Category** dropdown to filter expenses by specific categories such as Food, Transport, Entertainment, etc.
    - Use the **Month** picker to filter expenses by a particular month.
    - Filters can be combined for more precise results.

4. **Delete an Expense:**
    - Click the **"Delete"** link corresponding to the expense you wish to remove.
    - Confirm the deletion when prompted.

5. **Export Expenses:**
    - Click the **"Export Expenses as CSV"** button to download all your expenses in a CSV file format.
    - This file can be opened with spreadsheet applications like Microsoft Excel or Google Sheets for further analysis.

## Project Structure

- **expenses.csv**: The local CSV file storing all expense data. It includes the following columns:
    - **ID**: Unique identifier for each expense entry.
    - **Date**: The date of the expense.
    - **Category**: The category under which the expense falls (e.g., Food, Transport).
    - **Amount**: The monetary value of the expense.
    - **Description**: A brief description or note about the expense.

- **index.php**: The main PHP file that handles form submissions, CSV file operations, and renders the HTML interface.

- **styles.css**: Contains all the CSS styles for the application, ensuring a responsive and user-friendly interface.

## Contributing
Contributions are welcome! If you'd like to improve this project, please follow these steps:

1. **Fork the Repository.**
2. **Create a New Branch:**
    ```bash
    git checkout -b feature/YourFeatureName
    ```
3. **Commit Your Changes:**
    ```bash
    git commit -m 'Add some feature'
    ```
4. **Push to the Branch:**
    ```bash
    git push origin feature/YourFeatureName
    ```
5. **Open a Pull Request.**

Please ensure your code adheres to the existing style and includes appropriate comments where necessary.

## License
This project is open-source and available under the [MIT License](LICENSE).

## Contact
For any questions, issues, or suggestions, feel free to open an issue on the [GitHub repository](https://github.com/yasinULLAH/Expenses-tracker/tree/main).

---
Happy Tracking! 💰📈
