# AdaMov

AdaMov is a web application designed for managing and browsing movies. It features an **Admin Panel** with robust CRUD operations for managing movies, genres, users, and administrators, and a user-friendly website for exploring movie collections.

## Technologies Used

- **Backend**: PHP, PDO, MySQL
- **Frontend**: Bootstrap, CSS, HTML, jQuery, AJAX
- **Templates**: 
  - **Admin Panel**: [StartBootstrap](https://startbootstrap.com/)
  - **Website**: [Colorlib](https://colorib.com/)

## Features

### User-Facing Website
- Browse and discover movies.
- Comment and review movies
- Create and manage your account.

### Admin Panel
- **Movies**: Add, edit, delete, and manage movies.
- **Genres**: Manage movie categories.
- **Users**: View and manage user accounts.
- **Admins**: Manage admin users with restrictions to ensure data integrity.

## Installation

Follow these steps to set up and run AdaMov on your local environment:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Adamo08/adamov.git
   ```

2. **Navigate to the project directory**:
   ```bash
   cd AdaMov
   ```

3. **Set up the database**:
   - Create a MySQL database (e.g., `movies_db`).
   - Import the provided `db.sql` file into your database to create tables and seed initial data.

4. **Configure the database connection**:
   - Open the `config.php` file.
   - Update the database connection settings (e.g., username, password).
   - Ensure the port in the `HOST` constant matches your MySQL port (default: `3306`).

5. **Place the project in the server root**:
   - If you're using **XAMPP** or **WAMP**, place the project folder inside the `htdocs` directory.

6. **Start the local server**:
   - Start Apache and MySQL in your XAMPP/WAMP control panel.
   - Access the project via your browser at: `http://localhost/AdaMov/public/`.

## Usage

- **User Website**:
  - Register a new account or log in to browse movies.
- **Admin Panel**:
  - Access the admin panel at `http://localhost/AdaMov/public/admin`.
  - Log in using the admin credentials provided in `db.sql`.
  - Manage movies, genres, users, and admins directly from the admin dashboard.

## Attribution

### Templates Used

- **Admin Panel Template**:
  - Provided by [StartBootstrap](https://startbootstrap.com).
  - Licensed under the MIT License. For more details, visit the [StartBootstrap License Page](https://startbootstrap.com/about/licenses).

- **Website Template**:
  - Provided by [Colorlib](https://colorlib.com).
  - Licensed under the Creative Commons Attribution 3.0 License. Learn more at the [Colorlib License Page](https://colorlib.com/wp/licence/).

## Contributing

Contributions are welcome! Here's how you can contribute:

1. Fork the repository.
2. Create a new feature branch: `git checkout -b feature-name`.
3. Commit your changes: `git commit -m "Add new feature"`.
4. Push to the branch: `git push origin feature-name`.
5. Open a pull request and describe your changes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
