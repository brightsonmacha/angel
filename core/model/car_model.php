<?php
namespace core\Model;

include 'base_model.php';

class CarModel extends BaseModel
{

    public function getAllCars()
    {
        $sql = "SELECT * FROM cars ORDER BY id DESC";
        $result = mysqli_query($this->dbConn, $sql);

        $cars = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cars[] = $row;
        }
        return $cars;
    }

    public function getCarById($id)
    {
        $stmt = mysqli_prepare($this->dbConn, "SELECT * FROM cars WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function checkPlateExists($plateNumber, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = mysqli_prepare($this->dbConn, "SELECT id FROM cars WHERE plate_number = ? AND id != ?");
            mysqli_stmt_bind_param($stmt, "si", $plateNumber, $excludeId);
        } else {
            $stmt = mysqli_prepare($this->dbConn, "SELECT id FROM cars WHERE plate_number = ?");
            mysqli_stmt_bind_param($stmt, "s", $plateNumber);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    public function addCar($make, $model, $year, $plateNumber, $dailyRate)
    {
        $stmt = mysqli_prepare($this->dbConn, "INSERT INTO cars (make, model, year, plate_number, daily_rate, status) VALUES (?, ?, ?, ?, ?, 'available')");
        mysqli_stmt_bind_param($stmt, "ssiid", $make, $model, $year, $plateNumber, $dailyRate);
        return mysqli_stmt_execute($stmt);
    }

    public function updateCar($id, $make, $model, $year, $plateNumber, $dailyRate, $status)
    {
        $stmt = mysqli_prepare($this->dbConn, "UPDATE cars SET make = ?, model = ?, year = ?, plate_number = ?, daily_rate = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssiidsi", $make, $model, $year, $plateNumber, $dailyRate, $status, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function deleteCar($id)
    {
        $stmt = mysqli_prepare($this->dbConn, "DELETE FROM cars WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}
