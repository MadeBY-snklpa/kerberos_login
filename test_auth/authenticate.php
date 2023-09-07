<?php

$ldapServer = "ldap://adserver.hrs.lk";
$ldapAdminUsername = "authadmin@hrs.lk";
$ldapAdminPassword = "abc@123";

session_start(); // Start a session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the number of failed attempts from the session
    $failedAttempts = isset($_SESSION['failed_attempts']) ? $_SESSION['failed_attempts'] : 0;

    // If failed attempts exceed a threshold, prevent login
    if ($failedAttempts >= 3) {
        echo '<script>alert("Your account is locked due to too many failed login attempts. Please contact the administrator.");</script>';
        exit();
    }

    $ldapConnection = ldap_connect($ldapServer);
    if ($ldapConnection) {
        ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);

        // Determine the format of the provided username
        if (strpos($username, '\\') !== false) {
            // Format: hrs\username
            list($domain, $username) = explode('\\', $username);
            $bind = @ldap_bind($ldapConnection, $username . '@hrs.lk', $password);
        } elseif (strpos($username, '@') !== false) {
            // Format: username@hrs.lk
            $bind = @ldap_bind($ldapConnection, $username, $password);
        } else {
            // Format: username
            $bind = @ldap_bind($ldapConnection, $username . '@hrs.lk', $password);
        }

        if ($bind) {
            // Successful authentication, reset failed attempts and set session variables
            $_SESSION['failed_attempts'] = 0; // Reset failed attempts
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
            ini_set('session.gc_maxlifetime', 300);
            session_set_cookie_params(300);
            // Redirect to home page or wherever you want
            header("Location: home.php");
            exit();
        } else {
            // Authentication failed, update failed attempts and show an error message
            $_SESSION['failed_attempts'] = ++$failedAttempts; // Increment failed attempts
            echo '<script>alert("Authentication failed. Please check your username and password.");</script>';
            header("Refresh: 0; URL=index.php");
            exit();
        }

        ldap_close($ldapConnection);
    } else {
        $errorMessage = "Could not connect to LDAP server.";
    }
}
?>
