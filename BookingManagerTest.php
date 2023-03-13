<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

//import bookingmanager
require_once __DIR__ . '/BookingManager.php';

class BookingManagerTest extends TestCase
{
    protected static $manager;

    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();


        self::$manager = new BookingManager();
    }

    public function testGetStatusReturnsNullWhenBookingNotFound(): void
    {
        $bookingId = 123;
        $organisationId = 456;

        $result = self::$manager->getStatus($bookingId, $organisationId);

        $this->assertNull($result);
    }

    public function testGetStatusReturnsValidStatusWhenBookingFound(): void
    {
        // insert a test booking into the database
        $bookingId = 1;
        $organisationId = 1;
        $status = 'confirmed';

        $db = self::$manager->db;
        $stmt = $db->prepare('INSERT INTO bookings (booking_id, organisation_id, status) VALUES (:bookingId, :organisationId, :status)');
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->bindParam(':organisationId', $organisationId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        // check the status of the test booking
        $result = self::$manager->getStatus($bookingId, $organisationId);

        $this->assertEquals($status, $result);

        // delete the test booking from the database
        $stmt = $db->prepare('DELETE FROM bookings WHERE booking_id = :bookingId AND organisation_id = :organisationId');
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->bindParam(':organisationId', $organisationId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
