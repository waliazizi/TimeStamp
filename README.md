# TimeStamp

Application Description:

C.K Web Application is an Internet X.509 Public Key Infrastructure Time-Stamping Application that leverages FREETSA.ORG to provide accurate date and time stamping for various data formats.

Requirements:

For Linux Users:

For seamless operation, please ensure the following requirements are met:

Windows Users:

Install the light package of OpenSSL, which can be downloaded from the following link: https://slproweb.com/products/Win32OpenSSL.html

Prior to usage, install the Visual C++ 2008 Redistributables.

Add the system environment variable "Openssl" with the path to the OpenSSL bin directory (e.g., X:\path\to\openssl\bin).

CURL is required, and PHP Application must have the ability to run the system exec() command programmatically.

Database:

The database password is currently configured in the "dbconfig.php" file. Please note that this is not considered a best practice. For improved security, we recommend using alternative methods, such as environment variables, to manage sensitive information.

Database Password: @ll!swell

For XAMPP Users:

The "config.inc.php" file is included within the provided zip folder, which is useful when using XAMPP.

The database setup requires a password, and the relevant configuration file ("Config.inc.php") can be found inside the zip folder.

Maintenance:

The C.K Web Application is designed to be low-maintenance, requiring minimal intervention. However, please be aware that FreeTSA will renew their certificates after 20 years from the year 2017 to ensure continuous service. For any concerns or queries related to certificate renewal, kindly contact FreeTSA at the following email address: busilezas@busindre.com

Improvements:

To enhance security and customization options, we recommend the implementation of a self-signed CA (Certificate Authority) for stamping using your own certificates. This improvement will allow for greater control and confidence in the time-stamping process.
