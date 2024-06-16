<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

return static function (MBConfig $mbConfig): void {
    $mbConfig->packageDirectories([__DIR__ . '/plugins']);
    $version = $_SERVER['argv'][2];
    
    if(preg_match('/^[0-9]+\.[0-9]+\.[0-9]+$/', $version)) {
    	$mbConfig->defaultBranch('main');
    	$mbConfig->disableDefaultWorkers();
    	// 正式リリース
		$mbConfig->workers([
			UpdateReplaceReleaseWorker::class,
			SetCurrentMutualDependenciesReleaseWorker::class,
			AddTagToChangelogReleaseWorker::class,
			SetNextMutualDependenciesReleaseWorker::class,
			UpdateBranchAliasReleaseWorker::class,
			PushNextDevReleaseWorker::class
		]);
    } elseif(preg_match('/^[0-9]+\.[0-9]+\.[0-9]+-(alpha|beta|rc|dev)/', $version)) {
    	// alpha / beta / rc
    	$mbConfig->defaultBranch('dev');
    }
    

};
