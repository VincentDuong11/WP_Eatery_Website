<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');
require_once('PasswordHash.php');

class CustomerDAO extends abstractDAO
{
    public function __construct()
    {
        try {
            parent::__construct();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function addCustomer($cust)
    {
        if (!$this->mysqli->connect_errno) {
            $sql = 'INSERT INTO mailingList (customerName, phoneNumber, emailAddress, referrer) VALUES (?, ?, ?, ?)';
            // $sql .= "VALUES ($cust->getID(), $cust->getName(), $cust->getPhone(), $cust->getEmail(), $cust->getRef)";
            $stmt = $this->mysqli->prepare($sql);
            

            $name = $cust->getName();
            $phone = $cust->getPhone();
            $email = $cust->getEmail();
            $ref = $cust->getRef();

            $stmt->bind_param(
            'ssss',
            $name,
            $phone,
            $email,
            $ref
        );
            $stmt->execute();
            return true;
        } else {
            echo "connection error";
            return false;
        }
    }

    public function getAllCustomer()
    {
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        // $customers = mysqli_fetch_assoc($result);
        return $result;
    }

    public function checkDuplicatedEmail($email)
    {
        $hash = new PasswordHash(2, "dasdas");
        $res = $this->getAllCustomer();
        while ($customer = mysqli_fetch_assoc($res)) {
            if ($hash->CheckPassword($email, $customer['emailAddress'])) {
                return true;
            }
            // if ($customer['emailAddress'] == $email) {
            //     return true;
            // }
        }
        return false;
    }
}
