#!/usr/bin/env php
<?php
/**
 * Weekend Expense Splitter
 * 
 * Configure the data below, then run: php split.php
 */

// ============================================================
// 1) PEOPLE & NIGHTS STAYED
//    List every person and which nights they stayed (1, 2, 3).
// ============================================================
$people = [
    // Night 1 = Thursday, Night 2 = Friday, Night 3 = Saturday
    // Couple 1 — 3 nights
    'Torben P'   => [1, 2, 3],
    'Melissa'    => [1, 2, 3],
    // Couple 2 — 2 nights (arrived Friday)
    'Sander'     => [2, 3],
    'Valerie'    => [2, 3],
    // Couple 3 — Nina 3 nights, Torben Vdv 2 nights (arrived Friday)
    'Nina'       => [1, 2, 3],
    'Torben Vdv' => [2, 3],
    // Couple 4 — 3 nights
    'Idania'     => [1, 2, 3],
    'Bram'       => [1, 2, 3],
    // Couple 5 — Thomas 3 nights, Elsa 2 nights (cycled in Friday)
    'Thomas'     => [1, 2, 3],
    'Elsa'       => [2, 3],
    // Couple 6 — 2 nights (arrived Friday)
    'Bert'       => [2, 3],
    'Lani'       => [2, 3],
    // Couple 7 — 2 nights (arrived Friday)
    'Rahi'       => [2, 3],
    'Libby'      => [2, 3],
    // Couple 8 — 1 night (arrived Saturday)
    'Isha'       => [3],
    'Stan'       => [3],
    // Singles — 3 nights
    'Dries'      => [1, 2, 3],
    'Len'        => [1, 2, 3],
];

// ============================================================
// 2) COUPLES (optional)
//    Couples are treated as two individuals for splitting.
//    This is just informational / for display grouping.
// ============================================================
$couples = [
    ['Torben P', 'Melissa'],
    ['Sander', 'Valerie'],
    ['Nina', 'Torben Vdv'],
    ['Idania', 'Bram'],
    ['Thomas', 'Elsa'],
    ['Bert', 'Lani'],
    ['Rahi', 'Libby'],
    ['Isha', 'Stan'],
];

// ============================================================
// 3) GROUPS (reusable lists for expenses)
// ============================================================
$drinkers = array_values(array_diff(array_keys($people), ['Sander', 'Dries', 'Valerie']));

// ============================================================
// 4) EXPENSES
//    Each expense has:
//      - description: what it was for
//      - amount: total cost in euros
//      - paid_by: who fronted the money
//      - paid_for: who benefits — use names, or one of:
//            'all'          → everyone in $people
//            'night:1'      → everyone who stayed night 1
//            'night:2'      → everyone who stayed night 2
//            'night:3'      → everyone who stayed night 3
//            'night:1,2,3'  → everyone (house rental across all nights)
// ============================================================
$expenses = [
    [
        'description' => 'Huis',
        'amount'      => 920.55,
        'paid_by'     => 'Bram',
        'paid_for'    => 'all_nights', // equal cost per person-night
    ],
    [
        'description' => 'Rando Rail',
        'amount'      => 200.00,
        'paid_by'     => 'Torben P',
        'paid_for'    => ['Torben P', 'Melissa', 'Sander', 'Valerie', 'Nina', 'Torben Vdv',
                          'Thomas', 'Elsa', 'Bert', 'Lani', 'Rahi', 'Libby',
                          'Isha', 'Stan', 'Dries', 'Len'],
    ],
    [
        'description' => "Pizza's do",
        'amount'      => 84.00,
        'paid_by'     => 'Thomas',
        'paid_for'    => ['Thomas', 'Nina', 'Bram', 'Idania', 'Torben P', 'Melissa', 'Len'],
    ],
    [
        'description' => 'Stokbrood',
        'amount'      => 5.60,
        'paid_by'     => 'Thomas',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'Benzine Caddy',
        'amount'      => 50.00,
        'paid_by'     => 'Sander',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'IJs',
        'amount'      => 25.00,
        'paid_by'     => 'Isha',
        'paid_for'    => ['Torben P', 'Melissa', 'Sander', 'Valerie', 'Nina', 'Torben Vdv',
                          'Thomas', 'Elsa', 'Bert', 'Lani', 'Rahi', 'Libby',
                          'Isha', 'Stan', 'Dries', 'Len'],
    ],
    [
        'description' => 'Degage',
        'amount'      => 129.36,
        'paid_by'     => 'Nina',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'Orval',
        'amount'      => 33.00,
        'paid_by'     => 'Torben Vdv',
        'paid_for'    => $drinkers,
    ],
    [
        'description' => 'Boodschappen',
        'amount'      => 748.56,
        'paid_by'     => 'Torben P',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'Drank',
        'amount'      => 228.85,
        'paid_by'     => 'Torben P',
        'paid_for'    => $drinkers,
    ],
    [
        'description' => 'Benzine Bert',
        'amount'      => 38.00,
        'paid_by'     => 'Bert',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'BBQ groenten & boodschappen',
        'amount'      => 154.00,
        'paid_by'     => 'Bert',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'BBQ vlees & vis',
        'amount'      => 178.00,
        'paid_by'     => 'Bert',
        'paid_for'    => array_values(array_diff(array_keys($people), ['Melissa', 'Lani'])),
    ],
    [
        'description' => 'Benzine Rahi',
        'amount'      => 75.00,
        'paid_by'     => 'Rahi',
        'paid_for'    => 'all',
    ],
    [
        'description' => 'Paddenstoelen',
        'amount'      => 60.00,
        'paid_by'     => 'Nina',
        'paid_for'    => ['Melissa', 'Len', 'Bert', 'Nina'],
    ],
    [
        'description' => 'Benzine Micra',
        'amount'      => 31.79,
        'paid_by'     => 'Melissa',
        'paid_for'    => 'all',
    ],
    // [
    //     'description' => 'Groceries Friday',
    //     'amount'      => 120.00,
    //     'paid_by'     => 'Torben P',
    //     'paid_for'    => 'night:1',
    // ],
    // [
    //     'description' => 'Gas for travel',
    //     'amount'      => 60.00,
    //     'paid_by'     => 'Sander',
    //     'paid_for'    => ['Sander', 'Valerie', 'Torben Vdv'],
    // ],
    // [
    //     'description' => 'Beer run',
    //     'amount'      => 45.00,
    //     'paid_by'     => 'Bert',
    //     'paid_for'    => 'all',
    // ],
];


// ====================================================================
//  END OF CONFIGURATION — the code below does all the calculations
// ====================================================================

$names = array_keys($people);
$totalNights = 3;

// Build lookup: night → list of people present
$nightGuests = [];
for ($n = 1; $n <= $totalNights; $n++) {
    $nightGuests[$n] = [];
}
foreach ($people as $name => $nights) {
    foreach ($nights as $n) {
        $nightGuests[$n][] = $name;
    }
}

// Balances: positive = is owed money, negative = owes money
$paid = array_fill_keys($names, 0.0);  // total each person fronted
$owes = array_fill_keys($names, 0.0);  // total each person should pay

/**
 * Resolve a "paid_for" value into a list of names.
 */
function resolvePaidFor($paidFor, array $names, array $nightGuests): array
{
    if ($paidFor === 'all') {
        return $names;
    }

    if (is_array($paidFor)) {
        return $paidFor;
    }

    if (is_string($paidFor) && str_starts_with($paidFor, 'night:')) {
        $nightNums = explode(',', substr($paidFor, 6));
        $result = [];
        foreach ($nightNums as $n) {
            $n = (int) trim($n);
            if (isset($nightGuests[$n])) {
                $result = array_merge($result, $nightGuests[$n]);
            }
        }
        return array_unique($result);
    }

    // Single person
    return [$paidFor];
}

/**
 * For a "night:X,Y,Z" expense (like house rental), split the amount
 * proportionally per night, then per person present that night.
 * This ensures someone staying 1 night pays 1/3 of the nightly rate,
 * not 1/18 of the total.
 */
function splitNightExpense(float $amount, array $nightNums, array $nightGuests): array
{
    $perNight = $amount / count($nightNums);
    $shares = [];

    foreach ($nightNums as $n) {
        $guests = $nightGuests[$n] ?? [];
        if (empty($guests)) continue;
        $perPerson = $perNight / count($guests);
        foreach ($guests as $name) {
            $shares[$name] = ($shares[$name] ?? 0.0) + $perPerson;
        }
    }

    return $shares;
}

function calculateSettlements(array $balances): array
{
    $creditors = [];
    $debtors = [];

    foreach ($balances as $name => $balance) {
        if ($balance > 0.01) {
            $creditors[$name] = $balance;
        } elseif ($balance < -0.01) {
            $debtors[$name] = abs($balance);
        }
    }

    $settlements = [];

    foreach ($debtors as $dName => $dAmount) {
        foreach ($creditors as $cName => $cAmount) {
            if (abs($dAmount - $cAmount) < 0.01) {
                $settlements[] = ['from' => $dName, 'to' => $cName, 'amount' => round($dAmount, 2)];
                unset($debtors[$dName], $creditors[$cName]);
                break;
            }
        }
    }

    arsort($debtors);
    while (!empty($debtors) && !empty($creditors)) {
        arsort($creditors);
        $dName = array_key_first($debtors);
        $dAmount = $debtors[$dName];
        $cName = array_key_first($creditors);

        $amount = min($dAmount, $creditors[$cName]);
        $settlements[] = ['from' => $dName, 'to' => $cName, 'amount' => round($amount, 2)];

        $creditors[$cName] -= $amount;
        $debtors[$dName] -= $amount;

        if ($creditors[$cName] < 0.01) unset($creditors[$cName]);
        if ($debtors[$dName] < 0.01) unset($debtors[$dName]);
    }

    return $settlements;
}

// ── Calculate everything for a given house split mode ──
function calculateAll(array $expenses, array $people, array $names, array $nightGuests, string $houseMode): array
{
    $paid = array_fill_keys($names, 0.0);
    $owes = array_fill_keys($names, 0.0);
    $expenseDetails = [];
    $personExpenseShares = [];

    foreach ($expenses as $i => $exp) {
        $amount = $exp['amount'];
        $payer = $exp['paid_by'];
        $paidFor = $exp['paid_for'];

        $paid[$payer] += $amount;

        $isNightSplit = is_string($paidFor) && str_starts_with($paidFor, 'night:');
        $nightNums = [];
        if ($isNightSplit) {
            $nightNums = array_map('intval', explode(',', substr($paidFor, 6)));
        }

        if ($paidFor === 'all_nights') {
            if ($houseMode === 'per_person_night') {
                $totalPersonNights = 0;
                foreach ($people as $nights) {
                    $totalPersonNights += count($nights);
                }
                $costPerPersonNight = $amount / $totalPersonNights;
                $beneficiaries = $names;
                foreach ($names as $name) {
                    $share = $costPerPersonNight * count($people[$name]);
                    $owes[$name] += $share;
                    $personExpenseShares[$name][$i] = $share;
                }
            } else {
                // proportional per night
                $totalNights = max(array_map('count', $people));
                $allNights = range(1, $totalNights);
                $shares = splitNightExpense($amount, $allNights, $nightGuests);
                foreach ($shares as $name => $share) {
                    $owes[$name] += $share;
                    $personExpenseShares[$name][$i] = $share;
                }
                $beneficiaries = array_keys($shares);
            }
        } elseif ($isNightSplit && count($nightNums) > 1) {
            $shares = splitNightExpense($amount, $nightNums, $nightGuests);
            foreach ($shares as $name => $share) {
                $owes[$name] += $share;
                $personExpenseShares[$name][$i] = $share;
            }
            $beneficiaries = array_keys($shares);
        } else {
            $beneficiaries = resolvePaidFor($paidFor, $names, $nightGuests);
            $perPerson = $amount / count($beneficiaries);
            foreach ($beneficiaries as $name) {
                $owes[$name] += $perPerson;
                $personExpenseShares[$name][$i] = $perPerson;
            }
        }

        $expenseDetails[] = [
            'description'   => $exp['description'],
            'amount'        => $amount,
            'paid_by'       => $payer,
            'beneficiaries' => $beneficiaries,
        ];
    }

    $balances = [];
    foreach ($names as $name) {
        $balances[$name] = round($paid[$name] - $owes[$name], 2);
    }

    $settlements = calculateSettlements($balances);

    return compact('paid', 'owes', 'balances', 'expenseDetails', 'personExpenseShares', 'settlements');
}

$calc = calculateAll($expenses, $people, $names, $nightGuests, 'per_person_night');

$expenseDetails = $calc['expenseDetails'];
$totalExpenses = array_sum(array_column($expenseDetails, 'amount'));

// Build data for rendering
$sorted = $names;
usort($sorted, fn($a, $b) => $calc['owes'][$b] <=> $calc['owes'][$a]);

// Sort people by nights descending
$grouped = [];
foreach ($people as $name => $nights) {
    $grouped[count($nights)][] = $name;
}
krsort($grouped);

// House cost per-night info
$houseIdx = null;
foreach ($expenses as $i => $exp) {
    if ($exp['paid_for'] === 'all_nights') { $houseIdx = $i; break; }
}
$houseAmount = $houseIdx !== null ? $expenses[$houseIdx]['amount'] : 0;
$totalPersonNights = 0;
foreach ($people as $nights) $totalPersonNights += count($nights);
$costPerPersonNight = $houseAmount / $totalPersonNights;

$houseBreakdown = [];
foreach ([3, 2, 1] as $nc) {
    $sampleName = $grouped[$nc][0] ?? null;
    if (!$sampleName) continue;
    $stayedNights = $people[$sampleName];
    $perNight = array_map(fn($n) => round($costPerPersonNight, 2), $stayedNights);
    $total = round($calc['personExpenseShares'][$sampleName][$houseIdx] ?? 0, 2);
    $houseBreakdown[] = [
        'nights'   => $nc,
        'count'    => count($grouped[$nc]),
        'perNight' => $perNight,
        'total'    => $total,
    ];
}

$fmt = fn($v) => number_format($v, 2, ',', '.');

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Weekend Split</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Google+Sans+Text:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --ink: #202124;
    --paper: #ffffff;
    --border: #e0e0e0;
    --header-bg: #f8f9fa;
    --hover: #f1f3f4;
    --muted: #5f6368;
    --red: #e8590c;
    --green: #1e8e3e;
    --blue: #1a73e8;
    --font: 'Roboto', -apple-system, sans-serif;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: var(--font);
    font-size: 13px;
    font-weight: 400;
    background: #ffffff;
    color: var(--ink);
    padding: 24px;
    max-width: 100%;
    margin: 0 auto;
    line-height: 1.4;
  }

  /* ── Header ── */
  .header {
    padding-bottom: 16px;
    margin-bottom: 24px;
    border-bottom: 1px solid var(--border);
  }
  .header h1 {
    font-family: 'Google Sans Text', var(--font);
    font-size: 22px;
    font-weight: 400;
    color: var(--ink);
    margin-bottom: 8px;
  }
  .header .meta {
    display: flex;
    gap: 20px;
    font-size: 13px;
    color: var(--muted);
  }
  .header .meta strong { color: var(--ink); font-weight: 500; }

  /* ── Sections ── */
  .section {
    margin-bottom: 32px;
  }
  .section-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--ink);
    margin-bottom: 12px;
  }

  /* ── Tables ── */
  table {
    border-collapse: collapse;
    width: 100%;
    font-size: 13px;
  }
  th, td {
    padding: 7px 12px;
    text-align: center;
    border: 1px solid var(--border);
    font-weight: 400;
    vertical-align: middle;
  }
  th {
    font-size: 12px;
    font-weight: 500;
    color: var(--muted);
    background: var(--header-bg);
    border-bottom: 1px solid var(--border);
  }
  td:first-child, th:first-child { text-align: left; white-space: nowrap; }
  tbody tr:hover { background: var(--hover); }

  .num { font-variant-numeric: tabular-nums; }
  .dim { color: #dadce0; }
  .neg { color: var(--red); }
  .pos { color: var(--green); }
  .zero { color: var(--muted); }

  .total-row td {
    font-weight: 500;
    background: var(--header-bg);
    border-top: 2px solid #dadce0;
  }

  /* ── Avg line ── */
  .avg-line {
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 12px;
  }
  .avg-line strong { color: var(--ink); }

  /* ── Settlements ── */
  .settlements-grid {
    max-width: 420px;
  }
  .settle-row {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
  }
  .settle-row:last-child { border-bottom: none; }
  .settle-from { min-width: 100px; }
  .settle-arrow {
    color: var(--muted);
    margin: 0 10px;
    font-size: 14px;
  }
  .settle-to { flex: 1; }
  .settle-amount {
    font-weight: 500;
    font-variant-numeric: tabular-nums;
  }

  /* ── Breakdown bold cols ── */
  #breakdownTable td:nth-last-child(1) {
    font-weight: 500;
  }

  /* ── Footer ── */
  .footer {
    margin-top: 24px;
    padding: 12px 24px;
    font-size: 11px;
    color: var(--muted);
    text-align: center;
  }

  /* ── Responsive ── */
  .scroll-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  @media (max-width: 700px) {
    body { padding: 12px; }
    .header h1 { font-size: 18px; }
  }
</style>
</head>
<body>

<div class="header">
  <h1>Weekend Split</h1>
  <div class="meta">
    <span><strong><?= count($names) ?></strong> personen</span>
    <span><strong><?= $totalNights ?></strong> nachten</span>
    <span>Totaal <strong>€<?= $fmt($totalExpenses) ?></strong></span>
  </div>
</div>

<div class="section">
  <div class="section-label">Uitgaven</div>
  <table>
    <thead>
      <tr><th>Wat</th><th>Bedrag</th><th>Betaald door</th><th>Voor</th></tr>
    </thead>
    <tbody>
    <?php foreach ($expenseDetails as $exp): ?>
      <tr>
        <td><?= $exp['description'] ?></td>
        <td class="num">€<?= $fmt($exp['amount']) ?></td>
        <td><?= $exp['paid_by'] ?></td>
        <td class="num"><?= count($exp['beneficiaries']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr class="total-row">
        <td>Totaal</td>
        <td class="num">€<?= $fmt($totalExpenses) ?></td>
        <td></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>

<div class="section">
  <div class="section-label">Kostenverdeling</div>
  <div class="avg-line">Gem. per persoon: <strong>€<?= $fmt(array_sum($calc['owes']) / count($names)) ?></strong> · Gem. per persoon per dag: <strong>€<?= $fmt(array_sum($calc['owes']) / count($names) / 3) ?></strong></div>
  <div class="scroll-wrap">
    <table id="breakdownTable">
      <thead>
        <tr>
          <th>Naam</th>
          <?php foreach ($expenseDetails as $exp): ?>
            <th><?= $exp['description'] ?></th>
          <?php endforeach; ?>
          <th>Verschuldigd</th>
          <th>Betaald</th>
          <th>Balans</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($sorted as $name):
        $owes = $calc['owes'][$name];
        $paidAmt = $calc['paid'][$name];
        $balance = $calc['balances'][$name];
        $balClass = $balance > 0.01 ? 'pos' : ($balance < -0.01 ? 'neg' : 'zero');
      ?>
        <tr>
          <td><?= $name ?> <span class="dim">(<?= count($people[$name]) ?> <?= count($people[$name]) === 1 ? 'nacht' : 'nachten' ?>)</span></td>
          <?php foreach ($expenseDetails as $i => $exp):
            $share = $calc['personExpenseShares'][$name][$i] ?? 0;
          ?>
            <td class="num"><?= $share > 0.005 ? $fmt($share) : '<span class="dim">&middot;</span>' ?></td>
          <?php endforeach; ?>
          <td class="num"><?= $fmt($owes) ?></td>
          <td class="num"><?= $paidAmt > 0.01 ? $fmt($paidAmt) : '<span class="dim">&middot;</span>' ?></td>
          <td class="num <?= $balClass ?>"><?= $fmt($balance) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="total-row">
          <td>Totaal</td>
          <?php foreach ($expenseDetails as $exp): ?>
            <td class="num"><?= $fmt($exp['amount']) ?></td>
          <?php endforeach; ?>
          <td class="num"><?= $fmt(array_sum($calc['owes'])) ?></td>
          <td class="num"><?= $fmt(array_sum($calc['paid'])) ?></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<div class="section">
  <div class="section-label">Verrekeningen</div>
  <div class="settlements-grid">
    <?php foreach ($calc['settlements'] as $s): ?>
      <div class="settle-row">
        <span class="settle-from"><?= $s['from'] ?></span>
        <span class="settle-arrow">&rarr;</span>
        <span class="settle-to"><?= $s['to'] ?></span>
        <span class="settle-amount">&euro;<?= $fmt($s['amount']) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="footer">Generated <?= date('j M Y, H:i') ?></div>

</body>
</html>
<?php
$html = ob_get_clean();
$outFile = __DIR__ . '/index.html';
file_put_contents($outFile, $html);
echo "✅ Written to $outFile\n";
