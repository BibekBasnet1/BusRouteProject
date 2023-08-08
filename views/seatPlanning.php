<?php

//require "../models/Database_Connection.php";
session_start();

require_once "../models/Database_Connection.php";

// check if roll_id session variable is set
if (isset($_SESSION["roll_id"])) {
    // get the roll_id value from the session variable
    $roll_id = $_SESSION["roll_id"];

    //    $name = $_SESSION["name"];

} else {
    // if roll_id session variable is not set, redirect to login page
    header("Location: ../views/index.php");
    exit();
}

function dd($variable)
{
    // Start the output buffer to capture the var_dump() result
    ob_start();
    // Output the variable using var_dump() inside the buffer
    var_dump($variable);
    // Get the buffered contents and clean the buffer
    $output = ob_get_clean();
    // Wrap the output in <pre> tags to preserve line breaks and whitespace
    echo '<pre>' . $output . '</pre>';
    // Terminate the script
    die();
}

$queryValue = 0;

if (isset($_GET['submit'])) {
    if (isset($_GET['option']) && $_GET['option'] === '1') {
        $queryValue = 1;
    }
}


// take the bench and seatPer Bench in the classes 
$classes_available_for_exam = [
    'class 7' => [
        'bench' => 2,
        'seat_per_bench' => 4
    ],
    'class 8' => [
        'bench' => 2,
        'seat_per_bench' => 3
    ],
    'class 9' => [
        'bench' => 2,
        'seat_per_bench' => 2
    ],
    'class 10' => [
        'bench' => 2,
        'seat_per_bench' => 3
    ],
    'class 11' => [
        'bench' => 2,
        'seat_per_bench' => 3
    ]
];



$exam_classes = [
    'class 1' => [
        ['id' => 1, 'name' => 'Saral', 'roll' => 1],
        ['id' => 2, 'name' => 'Anish', 'roll' => 2],
        ['id' => 3, 'name' => 'Bipin', 'roll' => 3],
        ['id' => 4, 'name' => 'Milan', 'roll' => 4],
        ['id' => 5, 'name' => 'Achyut', 'roll' => 5],
        ['id' => 6, 'name' => 'Ram', 'roll' => 6],
        ['id' => 7, 'name' => 'Sita', 'roll' => 7],
        // ['id' => 8, 'name' => 'Sita', 'roll' => 7],
        // ['id' => 9, 'name' => 'Sita', 'roll' => 7],
        // ['id' => 10, 'name' => 'Sita', 'roll' => 7],
    ],
    'class 2' => [
        ['id' => 1, 'name' => 'Nikesh', 'roll' => 1],
        ['id' => 2, 'name' => 'Sanjil', 'roll' => 2],
        ['id' => 3, 'name' => 'Utsav', 'roll' => 3],
        ['id' => 4, 'name' => 'Rupak', 'roll' => 4],
        ['id' => 5, 'name' => 'Rabin', 'roll' => 5],
        // ['id' => 6, 'name' => 'A', 'roll' => 6],
        // ['id' => 7, 'name' => 'B', 'roll' => 7],

    ],
    'class 3' => [
        ['id' => 1, 'name' => 'Akriti', 'roll' => 1],
        ['id' => 2, 'name' => 'Prajwal', 'roll' => 2],
        ['id' => 3, 'name' => 'Janam', 'roll' => 3],
        ['id' => 4, 'name' => 'Bikal', 'roll' => 4],
        ['id' => 5, 'name' => 'Punam', 'roll' => 5],
        ['id' => 6, 'name' => 'C', 'roll' => 6],
    ],
    'class 4' => [
        ['id' => 1, 'name' => 'Ashish', 'roll' => 1],
        ['id' => 2, 'name' => 'Smrity', 'roll' => 2],
        ['id' => 3, 'name' => 'Sujit', 'roll' => 3],
        ['id' => 4, 'name' => 'Sanjan', 'roll' => 4],
        ['id' => 5, 'name' => 'Nirdesh', 'roll' => 5],
        // ['id' => 6, 'name' => 'Nirdesh', 'roll' => 5],
    ],
    'class 10' => [
        ['id' => 1, 'name' => 'Ram', 'roll' => 1],
        ['id' => 2, 'name' => 'Hari', 'roll' => 2],
        ['id' => 3, 'name' => 'Shyam', 'roll' => 3],
        ['id' => 4, 'name' => 'Krishna', 'roll' => 4],
        ['id' => 5, 'name' => 'Sagar', 'roll' => 5],
        ['id' => 6, 'name' => 'Bibek', 'roll' => 56],
        ['id' => 7, 'name' => 'Aakash', 'roll' => 7],
        ['id' => 8, 'name' => 'Bishal', 'roll' =>   8],
        // ['id' => 9, 'name' => 'Bishal', 'roll' => 8],
    ]
];





$seatsInClasses = [
    'class 7' => 0,
    'class 8' => 0,
    'class 9' => 0,
    'class 10' => 0,
    'class 11' => 0,
];

$examHall = [
    'class 7' => [],
    'class 8' => [],
    'class 9' => [],
    'class 10' => [],
    'class 11' => [],
];


// calculating the total number of students which will be total profit
$studentCount = 0;
foreach ($exam_classes as $exam => $students) {
    $studentCount += count($students);
}

// calculating the total weight for the selected classes 
$totalSeats = 0;
foreach ($classes_available_for_exam as $exam => $info) {
    $totalSeats += $info['bench'] * $info['seat_per_bench'];
    $seatsInClasses[$exam] = $info['bench'] * $info['seat_per_bench'];
}

// echo "Total Profit : " . $studentCount . " ";
// echo "Total Seats : " . $totalSeats;


// to assign the student a class in which class they are in 

foreach ($exam_classes as $exam => &$students) {
    foreach ($students as &$student) {
        $student['class'] = $exam;
    }
}
unset($student);


// $arrangeStudents = [];

// $selectedClasses = ['class 1', 'class 2','class 3','class 4','class 10'];
// dd($selectedClasses);
$selectedClasses = [];

foreach ($exam_classes as $class => $info) {

    array_push($selectedClasses, $class);
}


$selectedStudents = [];

// Merge the students from selectedClasses
foreach ($selectedClasses as $class) {
    if (isset($exam_classes[$class])) {
        $selectedStudents = array_merge($selectedStudents, $exam_classes[$class]);
    }
}


// Sort the selected students by id

usort($selectedStudents, function ($a, $b) {
    return $a['id'] - $b['id'];
});


$j = 0;
$index = 0;
$totalCapacity = [];

foreach ($classes_available_for_exam as $exam => $info) {
    array_push($totalCapacity, $info['bench'] * $info['seat_per_bench']);
}

// to compare the classes that has come adjacently
$unAllocatedStudents = [];
$prevClass = null;
$removeNext = false;

foreach ($selectedStudents as $key => $student) {
    $currentClass = $student['class'];

    if ($currentClass == $prevClass) {

        $unAllocatedStudents[] = $student;

        // Remove the current student from the $selectedStudents array
        unset($selectedStudents[$key]);
    }

    // Update the previous class with the current class for the next iteration.
    $prevClass = $currentClass;
}

// Reindex the $selectedStudents array after removing elements
$selectedStudents = array_values($selectedStudents);

foreach ($classes_available_for_exam as $class => $seatingArrangement) {
    $classCapacity = $seatingArrangement['bench'] * $seatingArrangement['seat_per_bench'];

    $examHall[$class] = array_slice($selectedStudents, 0, $classCapacity);
    $selectedStudents = array_slice($selectedStudents, $classCapacity);
}

?>
<!DOCTYPE html>

<head>
    <html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../resources/dash.css">

    <title>Admin</title>
    <style>
        #sidebar .side-menu li a {
            width: 100%;
            height: 100%;
            background: var(--light);
            display: flex;
            align-items: center;
            border-radius: 48px;
            font-size: 16px;
            color: var(--dark);
            white-space: nowrap;
            overflow-x: hidden;
        }

        .exam-hall {
            display: flex;
            flex-wrap: wrap;
        }

        .bench {
            flex: 0 0 100%;
            padding: 10px;
        }

        .seat {
            position: relative;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 10px;
        }
        .container{
            border: red;
        }

        .seat p {
            margin: 0;
            font-size: 1rem;
        }

        .tt.student-details {
            position: relative;
        }

        .tt.student-details:before,
        .tt.student-details:after {
            content: '';
            display: none;
        }

        .tt.student-details[data-bs-placement="bottom"]::before,
        .tt.student-details[data-bs-placement="bottom"]::after {
            content: '';
            display: none;
        }

        .tt.student-details[data-bs-placement="bottom"]::before {
            border-top: none;
            border-bottom: 5px solid #333;
        }

        .tt.student-details[data-bs-placement="bottom"]::after {
            border-top: none;
            border-bottom: 4px solid #007bff;
        }

        /* Additional styles */
        .text-center {
            text-align: center;
        }

        .text-light {
            color: #f8f9fa;
        }

        .fs-5 {
            font-size: 1rem;
        }

        .bg-primary {
            background-color: #007bff;
        }

        /* Swap Seats button styles (optional) */
        .btn.btn-primary.btn-sm {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .bench-number {
            font-weight: bold;
        }


        /* CSS for the exam hall container */
        .exam-hall.container {
            /* Your styles for the exam hall container go here */
        }

        /* CSS for the card */
        .card {
            /* Your styles for the card go here */
            display: block;
            margin: 20px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            background-color: #fff;
        }


        /* CSS for the card title */
        .card-title.text-center {
            /* Your styles for the card title go here */
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;

        }

        .card-body {
            /* display: flex; */
            justify-content: center;
            /* flex-direction: column; */
        }

        /* CSS for the card body */
        .card-body.text-white.bg-dark {
            /* Your styles for the card body go here */
            background-color: #343a40;
            color: #fff;
            padding: 15px;
        }

        /* CSS for the bench number */
        .bench-number.text-center.fs-5.m-3 {
            /* Your styles for the bench number go here */
            font-size: 1.4rem;
            margin: 1rem 0;
            text-align: center;
        }

        .card-body.text-white.bg-dark .bench-number:before,
        .card-body.text-white.bg-dark .bench-number:after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background-color: #fff;
            vertical-align: middle;
            margin: 0 8px;
        }

        .row.d-flex.justify-content-center {
            display: flex;
            margin: 4rem;
            justify-content: center;
        }

        .col-md-3 {
            /* flex: 0 0 25%; */
            flex: 0 0 250px;
            /* Adjust the width of the benches as needed */
            max-width: 250px;
            padding: 5px;

        }

        container-whole
        {
            display: flex;
        }

        .exam-hall.container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Center the benches horizontally */
        }

        /* Custom style for multiple students in a single row */
        .row.d-flex.justify-content-center .col-md-3:not(:last-child) {
            margin-right: 15px;
        }
    </style>
    <!-- <link href="toastr.css" rel="stylesheet"/> -->
</head>

<body>

    <div class="container-whole">
        <div class="sidebar-container">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="students-container">

            <div class="exam-hall container">
                <?php foreach ($examHall as $class => $students) { ?>
                    <div class="bench">
                        <div class="card">
                            <div class="card-header bg-dark-subtle">
                                <h3 class="card-title text-center"><?php echo $class; ?></h3>
                            </div>
                            <!-- <label><input type="checkbox" id="toggleCheckbox"> Show Allocated Students</label> -->
                            <div class="card-body text-white bg-dark">
                                <div class="row d-flex" id="studentList">
                                    <?php
                                    $seatingArrangement = $classes_available_for_exam[$class];
                                    $benchCapacity = $seatingArrangement['seat_per_bench'];
                                    $bench = $seatingArrangement['bench'];

                                    $currentBench = null;
                                    // Initialize an associative array to store counts for each class in the bench
                                    $classCounts = [];
                                    // Initialize an array to store removed students
                                    $removedStudents = [];
                                    foreach ($students as $index => $student) {
                                        $benchNumber = floor($index / $benchCapacity) + 1;
                                        $seatNumber = ($index % $benchCapacity) + 1;


                                        $studentName = isset($student['name']) ? $student['name'] : 'Unknown';
                                        $studentRoll = isset($student['roll']) ? $student['roll'] : 'Unknown';
                                        $studentId = isset($student['id']) ? $student['id'] : 'Unknown';
                                        $studentClass = isset($student['class']) ? $student['class'] : 'Unknown';

                                        $count = 0;
                                        // Display bench number only if it's different from the previous one
                                        if ($currentBench !== $benchNumber) {
                                            echo '</div>'; // Close previous row
                                            echo '<div class="bench-number text-center fs -5 m-3">Bench ' . $benchNumber . '</div>';

                                            echo '<div class="row d-flex justify-content-center">'; // Start a new row for the current bench
                                            $currentBench = $benchNumber;
                                        }

                                        echo '<div class="col-md-3">';
                                        echo '<div class="seat">';
                                        echo '<p class="text-center text-light  fs-5  bg-primary">Seat ' . $seatNumber . '</p>';

                                        // Increment the count for the current student's class in the bench
                                        if (!isset($classCounts[$studentClass])) {
                                            $classCounts[$studentClass] = 1;
                                        } else {
                                            $classCounts[$studentClass]++;
                                        }

                                        // Check if there are more than two students of the same class in the current bench
                                        if ($classCounts[$studentClass] > $bench && $queryValue == 1) {
                                            // Remove the last repeated student from the seating arrangement
                                            $classCounts[$studentClass]--;
                                            // Store the removed student in the $removedStudents array
                                            array_push($unAllocatedStudents, $student);
                                            continue;
                                        }

                                        echo '<span class="tt student-details" data-bs-placement="bottom" data-bs-toggle="tooltip"
                                 data-bs-title= "Roll Number: ' . $studentRoll . ', Id: ' . $studentId . ' , Class: ' . $studentClass . '">';
                                        echo '<p class="text-center">Name: ' . $studentName . " (" . $studentClass . ")" . '</p>';
                                        echo '</span>';
                                        echo '</div>';
                                        echo '</div>';
                                    }

                                    // Display the count for each class in the bench
                                    foreach ($classCounts as $class => $count) {
                                        if ($count > 1) {
                                            // $unAllocatedStudents.push()
                                            // echo '<p class="text-center">Number of Students in Bench (' . $class . '): ' . $count . '</p>';
                                        }
                                    }
                                    // Add the "Swap Seats" button
                                    // echo '<div class="col-md-3">';
                                    // echo '<button class="btn btn-primary btn-sm" onclick="swapSeats()">Swap Seats</button>';
                                    // echo '</div>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="card mt-4">
                <div class="card-header text-center">
                    <h3 class="card-title fs-4">UnAllocated Students</h3>
                </div>
                <div class="card-body text-center">
                    <?php foreach ($unAllocatedStudents as $student) { ?>
                        <p class=""><?php echo $student['id'] . " " . $student['name'] . " " . $student['roll'] . " " . $student['class']; ?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>


</body>
<script src="../resources/dash_code.js"></script>

</html>