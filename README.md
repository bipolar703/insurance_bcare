# Insurance Project with Nafath Integration

## About The Project

This is an insurance management system built with Laravel, featuring integration with the Nafath authentication system. The system provides a comprehensive solution for managing insurance requests and verification through Saudi Arabia's Nafath digital identity platform.

## Key Features

- Insurance request management
- Nafath authentication integration
- Two-factor verification system
- Admin dashboard for request management
- Real-time code verification
- Multi-step insurance application process

## Technical Stack

- Laravel Framework
- PHP 8.x
- MySQL Database
- Tailwind CSS
- Vite
- jQuery
- SweetAlert2

## Installation

1. Clone the repository:
```bash
git clone [your-repository-url]
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in .env file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Build assets:
```bash
npm run dev
```

## Usage

1. Start the development server:
```bash
php artisan serve
```

2. Access the application at: `http://localhost:8000`

## Features

- Multi-step insurance request process
- Nafath code verification system
- Admin dashboard for managing requests
- Real-time status updates
- Secure authentication system
- Comprehensive logging system

## Security

The project implements various security measures:
- CSRF protection
- Session management
- Secure code transmission
- Rate limiting
- Input validation

## Contributing

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is proprietary software. All rights reserved.

## Contact

Your Name - your.email@example.com

Project Link: [https://github.com/yourusername/insurance_project](https://github.com/yourusername/insurance_project)
