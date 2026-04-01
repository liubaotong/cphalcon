<?php

declare(strict_types=1);

/**
 * Converts pure-stub Codeception Cest files (those whose body is solely
 * $I->skipTest('Need implementation')) to PHPUnit Test skeletons under
 * tests/database/, then deletes the originals from tests/tocheck-database/.
 */
function convertCestToTest(
    string $sourceDir,
    string $targetDir,
    array $skipFiles = []
): void {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
        echo "  mkd: {$targetDir}\n";
    }

    $files = glob($sourceDir . '*.php');

    if (empty($files)) {
        echo "  (no .php files found)\n";
        return;
    }

    $created = 0;
    $skipped = 0;

    foreach ($files as $sourceFile) {
        $basename = basename($sourceFile);

        // Explicitly excluded (already has a real PHPUnit test)
        if (in_array($basename, $skipFiles, true)) {
            echo "  skip(excl):  {$basename}\n";
            ++$skipped;
            continue;
        }

        // Must be a Cest file
        if (!str_ends_with($basename, 'Cest.php')) {
            ++$skipped;
            continue;
        }

        $content = file_get_contents($sourceFile);

        // Only convert pure stubs
        if (!str_contains($content, "skipTest('Need implementation')")) {
            echo "  skip(impl):  {$basename}\n";
            ++$skipped;
            continue;
        }

        // ── Parse class name ──────────────────────────────────────────────────
        if (!preg_match('/^class (\w+)/m', $content, $m)) {
            echo "  skip(cls?):  {$basename}\n";
            ++$skipped;
            continue;
        }
        $cestClass = $m[1];
        $testClass = str_replace('Cest', 'Test', $cestClass);

        // ── Parse method name ─────────────────────────────────────────────────
        if (!preg_match('/    public function (\w+)\s*\(IntegrationTester/', $content, $m)) {
            echo "  skip(mth?):  {$basename}\n";
            ++$skipped;
            continue;
        }
        $cestMethod = $m[1];
        $testMethod = 'test' . ucfirst($cestMethod);

        $out = $content;

        // 1 – namespace  Integration → Database
        $out = str_replace(
            'Phalcon\Tests\Integration\\',
            'Phalcon\Tests\Database\\',
            $out
        );

        // 2 – use IntegrationTester → use AbstractDatabaseTestCase
        $out = str_replace(
            "\nuse IntegrationTester;\n",
            "\nuse Phalcon\\Tests\\AbstractDatabaseTestCase;\n",
            $out
        );

        // 3 – remove class-level docblock  /** \n * Class Foo\n */\n
        $out = preg_replace('#/\*\*\n \* Class \w+\n \*/\n#', '', $out);

        // 4 – class declaration
        $out = str_replace(
            "\nclass {$cestClass}\n",
            "\nfinal class {$testClass} extends AbstractDatabaseTestCase\n",
            $out
        );

        // 5 – method signature
        $out = str_replace(
            "    public function {$cestMethod}(IntegrationTester \$I)\n",
            "    public function {$testMethod}(): void\n",
            $out
        );

        // 6 – remove $I->wantToTest(...) line (handles single- and double-quoted)
        $out = preg_replace('/        \$I->wantToTest[^\n]*\n/', '', $out);

        // 7 – $I->skipTest → $this->markTestSkipped
        $out = str_replace(
            "        \$I->skipTest('Need implementation');",
            "        \$this->markTestSkipped('Need implementation');",
            $out
        );

        // 8 – ensure declare(strict_types=1) is present (some older stubs omit it)
        if (!str_contains($out, 'declare(strict_types=1);')) {
            $out = str_replace(
                "\nnamespace Phalcon\\Tests\\Database\\",
                "\ndeclare(strict_types=1);\n\nnamespace Phalcon\\Tests\\Database\\",
                $out
            );
        }

        // ── Write & delete ────────────────────────────────────────────────────
        $targetBasename = substr($basename, 0, -8) . 'Test.php'; // FooCest.php → FooTest.php
        $targetFile     = $targetDir . $targetBasename;

        file_put_contents($targetFile, $out);
        unlink($sourceFile);
        echo "  ✓  {$targetBasename}\n";
        ++$created;
    }

    echo "  result: created={$created} skipped={$skipped}\n\n";
}

$base = '/home/user/Work/niden-code/phalcon/cphalcon/tests/';
$src  = $base . 'tocheck-database/';
$tgt  = $base . 'database/';

// ── Batch 1 – Mvc/Model/Manager ──────────────────────────────────────────────
echo "=== Mvc/Model/Manager ===\n";
convertCestToTest(
    $src . 'Mvc/Model/Manager/',
    $tgt . 'Mvc/Model/Manager/',
    ['CreateBuilderCest.php']        // already has a real CreateBuilderTest.php
);

// ── Batch 2 – Mvc/Model/Binder ───────────────────────────────────────────────
echo "=== Mvc/Model/Binder ===\n";
convertCestToTest(
    $src . 'Mvc/Model/Binder/',
    $tgt . 'Mvc/Model/Binder/'
);

// ── Batch 3 – Mvc/Model/Relation ─────────────────────────────────────────────
echo "=== Mvc/Model/Relation ===\n";
convertCestToTest(
    $src . 'Mvc/Model/Relation/',
    $tgt . 'Mvc/Model/Relation/'
);

// ── Batch 4 – Mvc/Model/MetaData (top-level) ─────────────────────────────────
echo "=== Mvc/Model/MetaData (top-level) ===\n";
convertCestToTest(
    $src . 'Mvc/Model/MetaData/',
    $tgt . 'Mvc/Model/MetaData/'
);

// ── Batch 5 – Mvc/Model/MetaData/Strategy ────────────────────────────────────
echo "=== Mvc/Model/MetaData/Strategy (top-level) ===\n";
convertCestToTest(
    $src . 'Mvc/Model/MetaData/Strategy/',
    $tgt . 'Mvc/Model/MetaData/Strategy/'
);

echo "=== Mvc/Model/MetaData/Strategy/Annotations ===\n";
convertCestToTest(
    $src . 'Mvc/Model/MetaData/Strategy/Annotations/',
    $tgt . 'Mvc/Model/MetaData/Strategy/Annotations/'
);

echo "=== Mvc/Model/MetaData/Strategy/Introspection ===\n";
convertCestToTest(
    $src . 'Mvc/Model/MetaData/Strategy/Introspection/',
    $tgt . 'Mvc/Model/MetaData/Strategy/Introspection/'
);

// ── Batches 6-10 – MetaData adapters (ConstructCest has real impl, skip it) ──
foreach (['Apcu', 'Memory', 'Redis', 'Libmemcached', 'Stream'] as $adapter) {
    echo "=== Mvc/Model/MetaData/{$adapter} ===\n";
    convertCestToTest(
        $src . "Mvc/Model/MetaData/{$adapter}/",
        $tgt . "Mvc/Model/MetaData/{$adapter}/",
        ['ConstructCest.php']
    );
}

// ── Batch 11 – Db/Profiler ───────────────────────────────────────────────────
echo "=== Db/Profiler ===\n";
convertCestToTest(
    $src . 'Db/Profiler/',
    $tgt . 'Db/Profiler/'
);

// ── Batch 12 – Db/Result/Pdo ─────────────────────────────────────────────────
echo "=== Db/Result/Pdo ===\n";
convertCestToTest(
    $src . 'Db/Result/Pdo/',
    $tgt . 'Db/Result/Pdo/'
);

// ── Batch 13 – Db/Reference ──────────────────────────────────────────────────
echo "=== Db/Reference ===\n";
convertCestToTest(
    $src . 'Db/Reference/',
    $tgt . 'Db/Reference/'
);

// ── Batch 14 – Db/Index ──────────────────────────────────────────────────────
echo "=== Db/Index ===\n";
convertCestToTest(
    $src . 'Db/Index/',
    $tgt . 'Db/Index/'
);

// ── Batch 15 – Db top-level (SetupCest etc.) ─────────────────────────────────
echo "=== Db (top-level) ===\n";
convertCestToTest(
    $src . 'Db/',
    $tgt . 'Db/'
);

// ── Batch 16 – Db/Dialect/Mysql ──────────────────────────────────────────────
echo "=== Db/Dialect/Mysql ===\n";
convertCestToTest(
    $src . 'Db/Dialect/Mysql/',
    $tgt . 'Db/Dialect/Mysql/'
);

// ── Batch 17 – Db/Dialect/Postgresql (safety pass) ───────────────────────────
echo "=== Db/Dialect/Postgresql ===\n";
convertCestToTest(
    $src . 'Db/Dialect/Postgresql/',
    $tgt . 'Db/Dialect/Postgresql/'
);

// ── Batch 18 – Db/Dialect/Sqlite (safety pass) ───────────────────────────────
echo "=== Db/Dialect/Sqlite ===\n";
convertCestToTest(
    $src . 'Db/Dialect/Sqlite/',
    $tgt . 'Db/Dialect/Sqlite/'
);

echo "=== ALL DONE ===\n";

