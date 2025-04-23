<?php
require_once "logic/tax.php";

$netPay  = $taxPerc  = $payePerc  = $netPayPerc  = $gross  = $personalRelief  = $netPay  = $housingLevy  = $nssf  = $shif  = $paye  = $taxableIncome  = $salary = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["salary"], $_POST["calc_tax"])) {
    $salary = (float) str_replace(',', '', $_POST["salary"]);
    $result = calculateNetPay($salary);
    $taxPerc = $result["taxPerc"];
    $payePerc = $result["payePerc"];
    $netPayPerc = $result["netPayPerc"];
    $gross = $result["basicPay"];
    $personalRelief = $result["personalRelief"];
    $netPay = $result["netPay"];
    $housingLevy = $result["housingLevy"];
    $nssf = $result["nssf"];
    $shif = $result["shif"];
    $paye = $result["paye"];
    $taxableIncome = $result["taxableIncome"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenyan Tax Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <h1 class="text-center text-2xl font-bold text-gray-800 mb-6">Kenya Tax Calculator</h1>
    <div class="container mx-auto p-4 md:p-8 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Panel - Input Form -->
            <div class="w-full md:w-3/5 bg-white rounded-lg shadow-md p-6">
                <!-- Monthly Income Input -->
                <form method="POST" action="">
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2 text-sm">Monthly Income (KES)</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-gray-500 text-sm border-r pr-2">KES</span>
                            <input type="text" id="monthlyIncome" name="salary"
                                class="w-full p-3 pl-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder:text-sm"
                                <?= ($salary !== 0) ? "value='" . number_format($salary, 2) . "'" : ''  ?>
                                placeholder="Enter your monthly income" required>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button id="calculateBtn" name="calc_tax" class="bg-teal-500 text-white py-3 px-6 rounded-md hover:bg-teal-600 transition duration-300 w-full" type="submit">Calculate Tax</button>
                        <button id="resetBtn" type="submit" class="bg-white text-gray-700 border border-gray-300 py-3 px-6 rounded-md hover:bg-gray-50 transition duration-300 w-full">Reset</button>
                    </div>
                </form>

                <!-- Tax Bands Information -->
                <div class="mt-8 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 text-sm">Kenyan PAYE Tax Bands (2023)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm">Income Band (KES)</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-sm">Tax Rate</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Up to 24,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">10%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">24,001 - 32,333</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">25%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">32,334 - 500,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">30%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">500,001 - 800,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">32.5%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Above 800,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">35%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2 ">Other Important Information</h3>
                        <ul class="list-disc pl-5 space-y-1 text-gray-600 text-sm">
                            <li>Monthly Personal Relief: KES 2,400</li>
                            <li>NSSF Contribution: 6% of pensionable income (max KES 2,160 monthly)</li>
                            <li>SHIF Contribution: Graduated scale based on income</li>
                            <li>Housing Levy: 1.5% of gross monthly income</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- Right Panel - Results -->
            <div class="w-full md:w-2/5 bg-blue-900 text-white rounded-lg shadow-md p-6">
                <div class="text-center mb-8">
                    <h2 class="text-sm uppercase tracking-wide opacity-80">Estimated Net Pay</h2>
                    <div class="text-lg font-bold mt-2">KES <?= $netPay !== "" ? $netPay : "0" ?></span><span class="text-xl">/month</span></div>
                </div>
                <div class="space-y-3 mb-8">
                    <div class="flex justify-between">
                        <span class="text-sm">Gross Salary</span>
                        <span class="text-sm">KES <?= $gross !== "" ? $gross : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">Taxable Income</span>
                        <span class="text-sm">KES <?= $taxableIncome !== "" ? $taxableIncome : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">Personal Relief</span>
                        <span class="text-sm">KES <?= $personalRelief !== "" ? $personalRelief : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">PAYE</span>
                        <span class="text-sm">KES <?= $paye !== "" ? $paye : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">SHIF Contribution</span>
                        <span class="text-sm">KES <?= $shif !== "" ? $shif : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">NSSF Contribution</span>
                        <span class="text-sm">KES <?= $nssf !== "" ? $nssf : "0" ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm">Housing Levy</span>
                        <span class="text-sm">KES <?= $housingLevy !== "" ? $housingLevy : "0" ?></span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-center mb-4 text-sm">Payment Breakdown</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-md bg-blue-200 text-blue-900">
                                    Take Home Pay
                                </span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold inline-block text-blue-200">
                                    <?= $netPayPerc !== "" ? $netPayPerc : "0" ?>
                                </span>
                            </div>
                        </div>
                        <input
                            id="disabled-range"
                            type="range"
                            value="<?= $netPayPerc !== "" ? $netPayPerc : "0" ?>"
                            max="100"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            style="background: linear-gradient(to right, #14b8a6
                            <?= $netPayPerc !== '' ? $netPayPerc : '0' ?>%, #e5e7eb <?= $netPayPerc !== '' ? $netPayPerc : '0' ?>%)"
                            disabled>
                    </div>

                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-md bg-blue-200 text-blue-900">
                                    PAYE
                                </span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold inline-block text-blue-200">
                                    <?= $payePerc  !== "" ? $payePerc  : "0" ?>
                                </span>
                            </div>
                        </div>
                        <input
                            id="disabled-range"
                            type="range"
                            value="<?= $payePerc !== "" ? $payePerc : "0" ?>"
                            max="100"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            style="background: linear-gradient(to right, #dc2626 <?= $payePerc !== '' ? $payePerc : '0' ?>%, #e5e7eb <?= $payePerc !== '' ? $payePerc : '0' ?>%)"
                            disabled>
                    </div>

                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-md bg-blue-200 text-blue-900">
                                    Tax
                                </span>
                                <input type="range" id="taxRange" min="0" max="100" value="<?= $taxPerc !== "" ? $taxPerc : "0" ?>" class="hidden">
                            </div>
                            <div>
                                <span class="text-xs font-semibold inline-block text-blue-200">
                                    <?= $taxPerc !== "" ? $taxPerc : "0" ?>
                                </span>
                            </div>
                        </div>
                        <input
                            id="disabled-range"
                            type="range"
                            value="<?= $taxPerc !== "" ? $taxPerc : "0" ?>"
                            max="100"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            style="background: linear-gradient(to right, #eab308
                            <?= $taxPerc !== '' ? $taxPerc : '0' ?>%, #e5e7eb <?= $taxPerc !== '' ? $taxPerc : '0' ?>%)"
                            disabled>

                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center">
                    <div>
                        <div class="w-3 h-3 bg-teal-500 rounded-full mx-auto"></div>
                        <p class="text-xs mt-1">Net Pay</p>
                        <p class="text-sm font-bold" id="netPayPercent"><?= $netPayPerc !== "" ? $netPayPerc : "0" ?></p>
                    </div>
                    <div>
                        <div class="w-3 h-3 bg-red-500 rounded-full mx-auto"></div>
                        <p class="text-xs mt-1">PAYE</p>
                        <p class="text-sm font-bold" id="payePercent"><?= $payePerc  !== "" ? $payePerc  : "0" ?></p>
                    </div>
                    <div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mx-auto"></div>
                        <p class="text-xs mt-1">Tax</p>
                        <p class="text-sm font-bold" id="deductionsPercent"><?= $taxPerc !== "" ? $taxPerc : "0" ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const amountInput = document.getElementById("monthlyIncome");

        amountInput.addEventListener("input", (e) => {
            const cursorPosition = amountInput.selectionStart;
            const originalLength = amountInput.value.length;

            // Remove all characters except digits and the dot
            let rawValue = amountInput.value.replace(/[^\d.]/g, '');

            // Prevent multiple dots
            const parts = rawValue.split('.');
            if (parts.length > 2) {
                rawValue = parts[0] + '.' + parts[1];
            }

            const [intPart, decimalPart] = rawValue.split('.');

            let formatted = Number(intPart).toLocaleString('en-KE');

            if (decimalPart !== undefined) {
                formatted += '.' + decimalPart;
            }

            amountInput.value = formatted;

            // Restore cursor position
            const newLength = amountInput.value.length;
            const diff = newLength - originalLength;
            amountInput.setSelectionRange(cursorPosition + diff, cursorPosition + diff);
        });
    </script>

</body>

</html>