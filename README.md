# Travago - Travel Agencies Management App

Travago is a comprehensive web application designed to streamline the management processes for travel agencies. It offers a user-friendly interface for managing bookings, customer information, and more. This README provides an overview of the project structure, installation instructions, and key functionalities.

## Key Features

- **Booking Management**: Easily create, update, and manage bookings for various travel packages.
- **User Management**: Maintain detailed records of customers including contact information, preferences, and booking history.
- **Reporting and Analytics**: Generate reports and gain insights into booking trends, revenue, and more.

## Technologies Used

- **Frontend**:
  - HTML/CSS: **Tailwind** CSS and SASS for styling the user interface.
  - JavaScript: Handling client-side interactions.
- **Backend**:
  - PHP: Server-side scripting language.
- **Database**:
  - MySQL: Relational database management system.
  - phpMyAdmin: Web-based administration tool for MySQL.
- **Testing**:
  - VSCODE: Framework for unit testing PHP code.
- **Deployment**:
  - Docker: Containerization for seamless deployment across environments.

## Getting Started

### Prerequisites

- [Docker](https://www.docker.com/) installed on your system.
- [Git](https://git-scm.com/) installed for version control.
- [Visual Studio Code](https://code.visualstudio.com/) or any preferred text editor/IDE.

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/travago.git
    ```

2. Navigate to the project directory:

    ```bash
    cd travago
    ```

3. Build and run the Docker container:

    ```bash
    docker-compose up --build
    ```

4. Access the application via your web browser:

    ```bash
    http://localhost:8000
    ```

## Usage

- Upon accessing the application, you will be prompted to log in with your credentials.
- Once logged in, you can navigate through the various sections to manage bookings, customers, itineraries, etc.
- Refer to the Confluence documentation for detailed usage instructions and API endpoints.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests for any improvements or features you'd like to see added to the Travago app.

## License

This project is Open source.
