

<?php
use Kreait\Firebase\Factory;

$firebase = (new Factory)->withServiceAccount('path/to/firebase_credentials.json')->create();
$auth = $firebase->getAuth();
?>


