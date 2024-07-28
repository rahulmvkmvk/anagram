<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anagram</title>
    <link rel="stylesheet" href="pub/styles.css">
</head>
<body>
    <div class="result-container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['title'])) {
                $title = trim($_POST['title']);

                if (!preg_match("/^[a-zA-Z0-9 ._]{1,50}$/", $title)) {
                    die("Title can only contain letters, numbers, spaces, periods, and must be 50 characters or less.");
                }

                $filename = $title;
                if (file_exists($filename)) {
                    $words = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                    $anagrams = [];

                    foreach ($words as $word) {
                        $sortedWord = str_split($word);
                        sort($sortedWord);
                        $key = implode('', $sortedWord);

                        if (!isset($anagrams[$key])) {
                            $anagrams[$key] = [];
                        }
                        $anagrams[$key][] = $word;
                    }

                    $filteredAnagrams = array_filter($anagrams, function($group) {
                        return count($group) >= 2;
                    });

                    uasort($filteredAnagrams, function($a, $b) {
                        return count($b) - count($a);
                    });

                    if (!empty($filteredAnagrams)) {
                        echo "<table class='result-table'>";
                        echo "<tr><th>Count</th><th>Matching Strings</th></tr>";
                        foreach ($filteredAnagrams as $group) {
                            echo "<tr>";
                            echo "<td>" . count($group) . "</td>";
                            echo "<td>" . implode(", ", $group) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<div class='no-results'>No anagram pairs found with at least 2 matches.</div>";
                    }
                } else {
                    echo "<div class='no-results'>File not found: $filename</div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
