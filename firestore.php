

require 'vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

class FirestoreDB {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = new FirestoreClient([
            'keyFilePath' => __DIR__ . '/config/firebase_credentials.json'
        ]);
        $this->collection = $this->db->collection('users');
    }

    public function addUser($email, $password, $plan) {
        $docRef = $this->collection->document($email);
        $docRef->set([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'plan' => $plan,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUser($email) {
        $docRef = $this->collection->document($email);
        $snapshot = $docRef->snapshot();
        return $snapshot->exists() ? $snapshot->data() : null;
    }
}


