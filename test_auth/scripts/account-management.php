<?php
ini_set('session.gc_maxlifetime', 300);


session_set_cookie_params(300);
session_start(); // Start the session

$ldapServer = "ldap://172.22.81.221";
$ldapAdminUsername = "authadmin@hrs.lk";
$ldapAdminPassword = "abc@123";
// Connect to LDAP server
$ldapConn = ldap_connect($ldapServer);
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

// Bind as administrator
ldap_bind($ldapConn, $ldapAdminUsername, $ldapAdminPassword);

// Retrieve username from session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Check if the username contains "@" to handle both formats
    if (strpos($username, "@") !== false) {
        list($username, $domain) = explode("@", $username);
    }

    // Search for user
    $userFilter = "(sAMAccountName=$username)";
    $searchResults = ldap_search($ldapConn, "ou=colombo,dc=hrs,dc=lk", $userFilter);
    $userEntry = ldap_first_entry($ldapConn, $searchResults);

    if ($userEntry) {
        // Check group membership
        $memberOf = ldap_get_values($ldapConn, $userEntry, "memberOf");

        if (in_array("CN=hrp,OU=permission groups,DC=hrs,DC=lk", $memberOf)) {
             // Redirect to hive.com
             header("Location: https://www.example.com/");
             exit;
         } else {
             // Show dialog box with cancel button using JavaScript
             echo <<<HTML
             <script>
                 var result = confirm("You don't have permission to access this resource. Contact IT for assistance.");
                 if (result) {
                     history.go(-1); // Go back
                 }
             </script>
             HTML;
         }
     } else {
         // Show dialog box with cancel button using JavaScript
         echo <<<HTML
         <script>
             var result = confirm("User not found.");
             if (result) {
                 history.go(-1); // Go back
             }
         </script>
         HTML;
     }
 }

// Close LDAP connection
ldap_close($ldapConn);
?>
