<?php
// Fermat's Factorization Function with Iteration Tracking
function fermatFactorization($n) {
    if ($n % 2 == 0) {
        return [2, $n / 2, 1];  // Handle even numbers with 1 iteration
    }

    $x = ceil(sqrt($n));
    $y2 = $x * $x - $n;
    $iterations = 0;

    while (floor(sqrt($y2)) != sqrt($y2)) {
        $x++;
        $y2 = $x * $x - $n;
        $iterations++;
    }

    $y = sqrt($y2);
    $factor1 = $x - $y;
    $factor2 = $x + $y;

    return [$factor1, $factor2, $iterations];
}

// Trial Division Function with Iteration Tracking
function trialDivision($n) {
    $factors = [];
    $iterations = 0;

    // Check for number of 2s that divide n
    while ($n % 2 == 0) {
        $factors[] = 2;
        $n /= 2;
        $iterations++;
    }

    // n must be odd at this point, so we can skip one element
    for ($i = 3; $i <= sqrt($n); $i += 2) {
        while ($n % $i == 0) {
            $factors[] = $i;
            $n /= $i;
            $iterations++;
        }
    }

    // This condition is to check if n is a prime number greater than 2
    if ($n > 2) {
        $factors[] = $n;
        $iterations++;
    }

    return [$factors, $iterations];
}

// Pollard's Rho Function with Iteration Tracking
function pollardsRho($n) {
    if ($n % 2 == 0) return [2, $n / 2, 1]; // Handle even numbers with 1 iteration

    $x = 2;
    $y = 2;
    $d = 1;
    $iterations = 0;
    
    $f = function($x) use ($n) {
        return ($x * $x + 1) % $n; // Polynomial f(x) = x^2 + 1
    };

    while ($d == 1) {
        $x = $f($x);
        $y = $f($f($y)); // y moves twice as fast
        $d = gcd(abs($x - $y), $n);
        $iterations++;
    }

    if ($d == $n) return [null, null, $iterations]; // Failure, no factors found

    return [$d, $n / $d, $iterations];
}

// GCD Function
function gcd($a, $b) {
    while ($b != 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }
    return $a;
}

// Handle form submission
$iterations_fermat = 0;
$iterations_trial = 0;
$iterations_pollard = 0;
$result = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = intval($_POST['number']);
    $method = $_POST['method'];
    
    if ($number < 2) {
        $result = "<p class='error'>Please enter a valid number greater than 1.</p>";
    } else {
        // Fermat Factorization
        list($factor1_fermat, $factor2_fermat, $iterations_fermat) = fermatFactorization($number);
        $fermat_result = "Fermat's Factors: $factor1_fermat and $factor2_fermat (Iterations: $iterations_fermat)";
        
        // Trial Division
        list($factors_trial, $iterations_trial) = trialDivision($number);
        $trial_result = "Trial Division Factors: " . implode(", ", $factors_trial) . " (Iterations: $iterations_trial)";
        
        // Pollard's Rho
        list($factor1_pollard, $factor2_pollard, $iterations_pollard) = pollardsRho($number);
        if ($factor1_pollard === null) {
            $pollard_result = "Pollard's Rho failed to find factors (Iterations: $iterations_pollard)";
        } else {
            $pollard_result = "Pollard's Rho Factors: $factor1_pollard and $factor2_pollard (Iterations: $iterations_pollard)";
        }

        // Display the results
        $result = "
            <p class='result'>$fermat_result</p>
            <p class='result'>$trial_result</p>
            <p class='result'>$pollard_result</p>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factorization Results</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Factorization Methods</h1>
        <form method="POST">
            <label for="number">Enter a number to factorize:</label>
            <input type="number" id="number" name="number" required>
            <br>
            <button type="submit">Factorize</button>
        </form>

        <!-- Display result if available -->
        <?php if (isset($result)) echo $result; ?>

        <h2>Iterations Comparison</h2>
        <canvas id="complexityChart" width="400" height="200"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('complexityChart').getContext('2d');
        const complexityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Fermat\'s Factorization', 'Trial Division', 'Pollard\'s Rho'],
                datasets: [{
                    label: 'Number of Iterations',
                    data: [<?= $iterations_fermat ?>, <?= $iterations_trial ?>, <?= $iterations_pollard ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Iterations'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Factorization Method'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
