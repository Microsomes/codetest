<?php

declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


//i think .env file should be used to store the credentials, and not in the code, we may have many environments so we can use .env file to store the credentials for each environment
//e.g .env.development, .env.production, .env.staging etc


/**
 * The following code will be published to a production server.
 *
 * It's a simple script that allows a customer to view their booking status.
 *
 * Find as many errors or flaws as you can. You can edit the code inline, and/or
 * leave a comment where you think you've found a flaw.
 */


ini_set('display_errors', 'on');
error_reporting(E_ALL);

class BookingManager
{
	public PDO $db; //error 01 - wrong type, it should be PDO

	public function __construct()
	{
		$host = $_ENV['DB_HOST'];
		$db = $_ENV['DB_NAME'];
		$user = $_ENV['DB_USER'];
		$pass = $_ENV['DB_PASS'];

		$this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass); //pdo had hardcoded credentials which is not good, we should use .env file to store the credentials
	}

	/**
	 * Get the status of a booking. The primary key for the `bookings` table is (booking_id, organisation_id).
	 *
	 * @return string|null
	 */
	public function getStatus($bookingId, $organisationId): ?string
	{
		$stmt = $this->db->prepare('SELECT status FROM bookings WHERE organisation_id = :organisationId');
		$stmt->bindParam(':organisationId', $organisationId, PDO::PARAM_INT);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return (string)$stmt->fetchColumn();
		} else {
			return null;
		}
	}
}
