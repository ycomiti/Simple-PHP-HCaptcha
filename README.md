# Simple PHP HCaptcha

A simple implementation of hCaptcha on PHP >= 8.1.

## Features

- Easy to integrate hCaptcha with customizable themes and sizes.
- Supports verification of hCaptcha responses.
- Utilizes user IP address for verification.
- Example implementation provided.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/ycomiti/Simple-PHP-HCaptcha.git
   ```

2. Navigate to the project directory:

   ```bash
   cd Simple-PHP-HCaptcha
   ```

3. Make sure to set up your configuration file (`src/config.php`) with your hCaptcha public and private keys.

## Usage

### Configuration

You will need to replace the placeholders in the example code with your actual hCaptcha keys:

```php
$hCaptcha = new HCaptcha(
  "your_public_key", // Replace with your public key
  "your_private_key", // Replace with your private key
  HCaptchaTheme::DARK // Optional: Choose the theme
);
```

### HTML Form

Use the following HTML structure to display the hCaptcha widget:

```html
<form method="POST">
  <?= $hCaptcha->display() ?>
  <button type="submit">Submit</button>
</form>
```

### Verifying hCaptcha Response

To verify the user's response, you can handle the POST request as follows:

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['h-captcha-response'])) {
    $hCaptcha->verify($_POST['h-captcha-response']);
    $human = (boolean)$hCaptcha->isHuman();

    if ($human) {
      // User is verified as human
      echo "Verification successful!";
    } else {
      // Verification failed
      echo "Verification failed!";
    }
  }
}
```

## Classes

### HCaptcha

This class handles the hCaptcha integration. It requires the following parameters upon initialization:

- **publicKey**: Your hCaptcha public key.
- **secretKey**: Your hCaptcha secret key.
- **theme**: Optional theme for the captcha (defaults to LIGHT).
- **size**: Optional size for the captcha (defaults to NORMAL).
- **url**: Optional verification URL (defaults to `https://hcaptcha.com/siteverify`).
- **scriptUrl**: Optional script URL (defaults to `https://hcaptcha.com/1/api.js`).

### IPUtils

A utility class to retrieve the user's IP address.

### Enums

- **HCaptchaTheme**: Defines the theme options (LIGHT, DARK).
- **HCaptchaSize**: Defines the size options (NORMAL, COMPACT).

## Example

A complete example is provided in the `index.php` file, demonstrating how to set up and use the `HCaptcha` class in a simple HTML form.

## License

This project is licensed under the GNU General Public License v3.0. See the LICENSE file for details.

## Acknowledgments

- [hCaptcha](https://www.hcaptcha.com) for providing the captcha service.

## Repository

You can find the project repository [here](https://github.com/ycomiti/Simple-PHP-HCaptcha).
