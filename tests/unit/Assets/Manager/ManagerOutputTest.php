<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Unit\Assets\Manager;

use Phalcon\Assets\Asset;
use Phalcon\Assets\Collection;
use Phalcon\Assets\Exception;
use Phalcon\Assets\Manager;
use Phalcon\Html\Escaper;
use Phalcon\Html\TagFactory;
use Phalcon\Tests\AbstractUnitTestCase;
use Phalcon\Tests\Unit\Assets\Fake\FakeAssetFileExistsPositive;
use Phalcon\Tests\Unit\Assets\Fake\UppercaseFilter;

use function filemtime;
use function file_put_contents;
use function ob_get_clean;
use function ob_start;
use function outputDir;
use function supportDir;
use function touch;

use const PHP_EOL;

/**
 * Covers the remaining uncovered branches in Phalcon\Assets\Manager.
 */
final class ManagerOutputTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Assets\Manager :: calculatePrefixedPath() - autoVersion
     * Covers L828-829: collection->isAutoVersion() && collection->isLocal()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerCalculatePrefixedPathAutoVersion(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $cssFile = supportDir('assets/assets/1198.css');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->setAutoVersion(true);
        // isLocal() defaults to true
        $collection->addCss($cssFile);
        // No collection-level filters → no-filter else path → calculatePrefixedPath called

        $actual      = $manager->output($collection, 'css');
        $modTime     = filemtime($cssFile);

        $this->assertStringContainsString('?ver=' . $modTime, $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: calculatePrefixedPath() - version set
     * Covers L833: if ($version) { $prefixedPath .= '?ver=' . $version; }
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerCalculatePrefixedPathVersion(): void
    {
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->setVersion('2.0.0');
        $collection->addCss('css/style.css', false);
        // No filters → no-filter else path → calculatePrefixedPath called
        // version='2.0.0', isAutoVersion=false → skip auto-version block
        // if ($version) → L833

        $actual = $manager->output($collection, 'css');

        $this->assertStringContainsString('?ver=2.0.0', $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: doCallback() - non-empty attributes
     * Also covers processParameters() - 'local' key in array (L1088-1089+1091)
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerDoCallbackNonEmptyAttributes(): void
    {
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        // Asset with 'local' in attributes (no numeric [1] key)
        // When doCallback fires: attributes[0] = prefixedPath → [0=>'...', 'local'=>true]
        // processParameters: isset($params[1]) = false, isset($params["local"]) = true → L1088-1091
        $collection = new Collection();
        $collection->addCss('css/style.css', false, false, ['local' => true]);
        // No collection-level filters → no-filter else path → doCallback with asset attributes

        $actual = $manager->output($collection, 'css');

        $this->assertNotEmpty($actual);
        $this->assertStringContainsString('css/style.css', $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: getJoin() - completeTargetPath is directory
     * Covers L929-931: exception when join=false and target is a directory
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerGetJoinDirectoryTargetPathException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('is not a valid target path (2)');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addCss('css/style.css');
        $collection->addFilter(new UppercaseFilter());
        $collection->setTargetPath(outputDir('tests/assets/'));  // existing directory
        $collection->join(false);

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: getJoin() - empty completeTargetPath
     * Covers L923-925: exception when join=false and target path is empty
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerGetJoinEmptyTargetPathException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('is not a valid target path (1)');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addCss('css/style.css');
        $collection->addFilter(new UppercaseFilter());
        // No setTargetPath → completeTargetPath = ''
        $collection->join(false);

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - collection sourcePath is set
     * Covers L419: $completeSourcePath .= $collectionSourcePath
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputCollectionSourcePath(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $targetFile = outputDir('tests/assets/cov_srcpath_' . $this->getNewFileName() . '.css');

        $manager = new Manager(new TagFactory(new Escaper()), [
            'sourceBasePath' => supportDir(),
        ]);
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->setSourcePath('assets/');  // L419: appended to sourceBasePath
        $collection->addCss('assets/1198.css');  // relative to completeSourcePath
        $collection->addFilter(new UppercaseFilter());
        $collection->setTargetPath($targetFile);
        $collection->setTargetUri('combined.css');
        $collection->join(true);

        $manager->output($collection, 'css');

        $this->assertFileExists($targetFile);
        $this->safeDeleteFile($targetFile);
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - implicit echo when not joining
     * Covers L591: echo $html when implicitOutput=true and join=false
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputEchoImplicit(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $prefix  = outputDir('tests/assets/') . 'cov_echo_nojoin_';
        $cssFile = supportDir('assets/assets/1198.css');

        $asset = new Asset('css', $cssFile);
        $asset->setTargetPath('echo_nojoin.css');

        $collection = new Collection();
        $collection->add($asset);
        $collection->addFilter(new UppercaseFilter());
        $collection->setTargetPath($prefix);  // non-empty, non-directory prefix for getJoin
        $collection->setTargetUri('combined.css');
        $collection->join(false);

        $manager = new Manager(new TagFactory(new Escaper()));
        // implicitOutput = true (default)

        ob_start();
        $manager->output($collection, 'css');
        $html = ob_get_clean();

        $this->assertNotEmpty($html);

        $this->safeDeleteFile($prefix . 'echo_nojoin.css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: getOutput() - implicit echo when joining
     * Covers L972: echo $html in getOutput() when implicitOutput=true
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputEchoImplicitJoin(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $targetFile = outputDir('tests/assets/cov_echo_join_' . $this->getNewFileName() . '.css');
        $cssFile    = supportDir('assets/assets/1198.css');

        $collection = new Collection();
        $collection->addCss($cssFile);
        $collection->addFilter(new UppercaseFilter());
        $collection->setTargetPath($targetFile);
        $collection->setTargetUri('combined.css');
        $collection->join(true);

        $manager = new Manager(new TagFactory(new Escaper()));
        // implicitOutput = true (default)

        ob_start();
        $manager->output($collection, 'css');
        $html = ob_get_clean();

        $this->assertNotEmpty($html);
        $this->assertFileExists($targetFile);

        $this->safeDeleteFile($targetFile);
    }

    /**
     * Tests Phalcon\Assets\Manager :: getSourcePath() - empty source path exception
     * Covers L995-999: throw when getRealSourcePath returns empty string
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputEmptySourcePathException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("does not have a valid source path");

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->add(new Asset('css', 'nonexistent_source_for_coverage.css'));
        $collection->addFilter(new UppercaseFilter());
        $collection->join(true);
        // completeSourcePath = '' → realpath('' + 'nonexistent...') = false → ''

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - empty target path exception
     * Covers L469-471: throw when getRealTargetPath returns empty string
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputEmptyTargetPathException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("does not have a valid target path");

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        // FakeAssetFileExistsPositive always returns true for phpFileExists
        // When the file doesn't actually exist, realpath returns false → empty string
        $asset = new FakeAssetFileExistsPositive('css', 'nonexistent_target_for_coverage.css');
        $asset->setSourcePath(supportDir('assets/assets/1198.css'));

        $collection = new Collection();
        $collection->add($asset);
        $collection->addFilter(new UppercaseFilter());
        $collection->join(true);
        // completeTargetPath = '' → getRealTargetPath('') on fake asset:
        //   completePath = '' + 'nonexistent...' → phpFileExists = true, realpath = false → ''

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: outputInlineCss() - with named collection
     * Covers L718: $collection = $this->get($name)
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInlineCssWithName(): void
    {
        $css     = 'p { color: #000099 }';
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);
        $manager->collection('my-styles')->addInlineCss($css);

        $expected = "<style type=\"text/css\">{$css}</style>" . PHP_EOL;
        $actual   = $manager->outputInlineCss('my-styles');

        $this->assertSame($expected, $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: outputInline() - filter is applied
     * Covers L669: $content = $filter->filter($content)
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInlineFilterApplied(): void
    {
        $css     = 'p { color: red; }';
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addInlineCss($css);
        $collection->addFilter(new UppercaseFilter());
        $collection->join(true);

        $actual = $manager->outputInline($collection, 'style');

        $this->assertStringContainsString('P { COLOR: RED; }', $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: outputInline() - invalid filter exception
     * Covers L661-662: throw when filter is not an object
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInlineInvalidFilterException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The filter is not valid');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addInlineCss('p { color: red; }');
        $collection->setFilters(['not-an-object']);

        $manager->outputInline($collection, 'style');
    }

    /**
     * Tests Phalcon\Assets\Manager :: outputInlineJs() - with named collection
     * Covers L736: $collection = $this->get($name)
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInlineJsWithName(): void
    {
        $js      = 'alert("Hello");';
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);
        $manager->collection('my-scripts')->addInlineJs($js);

        $expected = "<script type=\"application/javascript\">{$js}</script>" . PHP_EOL;
        $actual   = $manager->outputInlineJs('my-scripts');

        $this->assertSame($expected, $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: outputInline() - join=false path
     * Covers L675-680: each inline code gets its own element tag
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInlineNoJoin(): void
    {
        $css     = 'p { color: red; }';
        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addInlineCss($css);
        $collection->addFilter(new UppercaseFilter());
        $collection->join(false);  // join=false → L675-680 per-code element

        $actual = $manager->outputInline($collection, 'style');

        $this->assertStringContainsString('P { COLOR: RED; }', $actual);
        $this->assertStringContainsString('<style', $actual);
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - invalid filter exception
     * Covers L527: throw when filter is not an object (in output())
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputInvalidFilterException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The filter is not valid');

        $cssFile    = supportDir('assets/assets/1198.css');
        $targetFile = outputDir('tests/assets/cov_inv_filter_' . $this->getNewFileName() . '.css');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addCss($cssFile);
        $collection->setFilters(['not-an-object']);
        $collection->setTargetPath($targetFile);
        $collection->setTargetUri('combined.css');
        $collection->join(true);

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - no asset filter with join=true
     * Covers L551-552: $filteredJoinedContent .= $content when mustFilter=false
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputNoFilterJoin(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $cssFile    = supportDir('assets/assets/1198.css');
        $targetFile = outputDir('tests/assets/cov_nofilter_join_' . $this->getNewFileName() . '.css');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $collection = new Collection();
        $collection->addCss($cssFile, true, false);  // filter=false on asset
        $collection->addFilter(new UppercaseFilter());  // collection has filter
        $collection->setTargetPath($targetFile);
        $collection->setTargetUri('combined.css');
        $collection->join(true);

        $manager->output($collection, 'css');

        // Content written raw (not uppercased) because asset filter=false
        $this->assertFileExists($targetFile);
        $this->safeDeleteFile($targetFile);
    }

    /**
     * Tests Phalcon\Assets\Manager :: output() - no asset filter with join=false
     * Covers L554: $filteredContent = $content when mustFilter=false and join=false
     * Covers L563: file_put_contents when not joining
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputNoFilterNoJoin(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $cssFile = supportDir('assets/assets/1198.css');
        $prefix  = outputDir('tests/assets/') . 'cov_noflt_nojoin_';

        $asset = new Asset('css', $cssFile, true, false);  // filter=false on asset
        $asset->setTargetPath('output.css');

        $collection = new Collection();
        $collection->add($asset);
        $collection->addFilter(new UppercaseFilter());  // collection has filter
        $collection->setTargetPath($prefix);  // non-empty, non-directory prefix for getJoin
        $collection->join(false);

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $manager->output($collection, 'css');

        $targetPath = $prefix . 'output.css';
        $this->assertFileExists($targetPath);
        $this->safeDeleteFile($targetPath);
    }

    /**
     * Tests Phalcon\Assets\Manager :: isFilterNeeded() - same source and target paths
     * Covers L1024-1026: throw when targetPath === sourcePath
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputSameSourceTargetPathException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("have the same source and target paths");

        $cssFile = supportDir('assets/assets/1198.css');

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        // No targetBasePath/targetPath → completeTargetPath = ''
        // Per-asset: getRealTargetPath('') → completePath = '' + $cssFile → phpFileExists = true
        //   → realpath($cssFile) = $cssFile
        // sourcePath = realpath('' + $cssFile) = $cssFile
        // targetPath == sourcePath → L1024 exception!
        $collection = new Collection();
        $collection->addCss($cssFile);
        $collection->addFilter(new UppercaseFilter());
        $collection->join(true);

        $manager->output($collection, 'css');
    }

    /**
     * Tests Phalcon\Assets\Manager :: isFilterNeeded() - target exists with different mtime
     * Covers L1030-1031: filterNeeded=true when target file exists and filemtime differs
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsManagerOutputTargetExistsFiletimeDiffers(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->markTestSkipped('Need to fix Windows new lines...');
        }

        $cssFile    = supportDir('assets/assets/1198.css');
        $prefix     = outputDir('tests/assets/') . 'cov_fmtime_';
        $targetFile = $prefix . 'differs.css';

        // Pre-create target file with an older mtime than the source
        file_put_contents($targetFile, 'old content');
        touch($targetFile, filemtime($cssFile) - 1000);

        $asset = new Asset('css', $cssFile, true, false);  // filter=false
        $asset->setTargetPath('differs.css');

        $collection = new Collection();
        $collection->add($asset);
        $collection->addFilter(new UppercaseFilter());
        $collection->setTargetPath($prefix);  // non-empty, non-directory prefix for getJoin
        $collection->join(false);

        $manager = new Manager(new TagFactory(new Escaper()));
        $manager->useImplicitOutput(false);

        $manager->output($collection, 'css');

        // L1031 fired: filterNeeded=true → L554: filteredContent=content → L563: written
        $this->assertFileExists($targetFile);

        $this->safeDeleteFile($targetFile);
    }
}
