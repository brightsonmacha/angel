<?php

use core\Model\CarModel;
use core\Util\Validator;

include_once "core/auth/checklogin.php";
include_once "core/db/connection.php";
include_once "core/utils/validator.php";
include_once "core/model/car_model.php";

$validation = new Validator();
$carModel = new CarModel();

$editCar = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    $make = $validation->sanitizeInput($_POST['make'] ?? '');
    $model = $validation->sanitizeInput($_POST['model'] ?? '');
    $year = (int) ($_POST['year'] ?? 0);
    $plateNumber = $validation->sanitizeInput($_POST['plate_number'] ?? '');
    $dailyRate = (float) ($_POST['daily_rate'] ?? 0);

    $error = "";

    if (strlen($make) == 0 || strlen($model) == 0 || strlen($plateNumber) == 0) {
        $error = 'Make, model and plate number are required';
    } elseif ($year < 1900 || $year > (int) date('Y') + 1) {
        $error = 'Provide a valid year';
    } elseif ($dailyRate <= 0) {
        $error = 'Daily rate must be greater than 0';
    }

    if ($action == 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $status = ($_POST['status'] ?? '') == 'rented' ? 'rented' : 'available';
    }

    //checking error
    if (strlen($error) == 0 && $carModel->checkPlateExists($plateNumber, $action == 'update' ? $id : null)) {
        $error = 'A car with this plate number already exists';
    }

    if (strlen($error) > 0) {
        $errorH = "<b>Please fix error.</b> <br>" . $error;

        if ($action == 'update') {
            $editCar = ['id' => $id, 'make' => $make, 'model' => $model, 'year' => $year, 'plate_number' => $plateNumber, 'daily_rate' => $dailyRate, 'status' => $status];
        }
    } else {
        if ($action == 'update') {
            if ($carModel->updateCar($id, $make, $model, $year, $plateNumber, $dailyRate, $status)) {
                $msg = "Car updated successfully";
            } else {
                $errorH = "Fail to update car, try again.";
            }
        } else {
            if ($carModel->addCar($make, $model, $year, $plateNumber, $dailyRate)) {
                $msg = "Car added successfully";
            } else {
                $errorH = "Fail to add car, try again.";
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $carModel->deleteCar((int) $_GET['delete']);
    header("Location: cars.php");
    exit;
}

if (isset($_GET['edit']) && !$editCar) {
    $editCar = $carModel->getCarById((int) $_GET['edit']);
}

$cars = $carModel->getAllCars();

?>


<!DOCTYPE html>
<html>
<title>Cars || Angel System</title>
<?php include_once "includes/css.php"; ?>

<body>


    <div class="main-content">

        <div class="sidebar rnd4">
            <a href="dashboard.php">Dashboard</a>
            <a class="active" href="cars.php">Cars</a>
            <a href="">Rent</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </div>

        <div class="content rnd8">

            <h2><?php echo $editCar ? 'Edit Car' : 'Add Car'; ?></h2>

            <?php include_once 'includes/error_msg.php'; ?>

            <form method="POST" action="cars.php" class="form-group car-form">

                <input type="hidden" name="action" value="<?php echo $editCar ? 'update' : 'add'; ?>">
                <?php if ($editCar): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editCar['id']); ?>">
                <?php endif; ?>

                <label for="make"><b>Make</b></label>
                <input type="text" placeholder="e.g. Toyota" name="make" value="<?php echo htmlspecialchars($editCar['make'] ?? ''); ?>" required>

                <label for="model"><b>Model</b></label>
                <input type="text" placeholder="e.g. Corolla" name="model" value="<?php echo htmlspecialchars($editCar['model'] ?? ''); ?>" required>

                <label for="year"><b>Year</b></label>
                <input type="number" placeholder="e.g. 2022" name="year" value="<?php echo htmlspecialchars($editCar['year'] ?? ''); ?>" required>

                <label for="plate_number"><b>Plate Number</b></label>
                <input type="text" placeholder="e.g. KDA 123X" name="plate_number" value="<?php echo htmlspecialchars($editCar['plate_number'] ?? ''); ?>" required>

                <label for="daily_rate"><b>Daily Rate</b></label>
                <input type="number" step="0.01" placeholder="e.g. 45.00" name="daily_rate" value="<?php echo htmlspecialchars($editCar['daily_rate'] ?? ''); ?>" required>

                <?php if ($editCar): ?>
                    <label for="status"><b>Status</b></label>
                    <select name="status" class="rnd4">
                        <option value="available" <?php echo ($editCar['status'] ?? '') == 'available' ? 'selected' : ''; ?>>Available</option>
                        <option value="rented" <?php echo ($editCar['status'] ?? '') == 'rented' ? 'selected' : ''; ?>>Rented</option>
                    </select>
                <?php endif; ?>

                <button type="submit" class="btn btn-blue rnd8"><?php echo $editCar ? 'Update Car' : 'Add Car'; ?></button>
                <?php if ($editCar): ?>
                    <a href="cars.php" class="btn btn-default rnd8">Cancel</a>
                <?php endif; ?>

            </form>

            <h2>All Cars</h2>

            <?php if (count($cars) == 0): ?>
                <p>No cars added yet.</p>
            <?php else: ?>
                <table class="car-table">
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Plate Number</th>
                        <th>Daily Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($car['make']); ?></td>
                            <td><?php echo htmlspecialchars($car['model']); ?></td>
                            <td><?php echo htmlspecialchars($car['year']); ?></td>
                            <td><?php echo htmlspecialchars($car['plate_number']); ?></td>
                            <td><?php echo htmlspecialchars($car['daily_rate']); ?></td>
                            <td><?php echo htmlspecialchars($car['status']); ?></td>
                            <td>
                                <a href="cars.php?edit=<?php echo (int) $car['id']; ?>" class="a-link">Edit</a>
                                &nbsp;|&nbsp;
                                <a href="cars.php?delete=<?php echo (int) $car['id']; ?>" class="a-link" onclick="return confirm('Delete this car?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

        </div>

    </div>

    <?php include_once "includes/js.php"; ?>
</body>

</html>
