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
		/**
         * 正式リリース
         * タグの送信とマスタの送信
         */
		$mbConfig->defaultBranch('main');
		$mbConfig->workers([
			UpdateReplaceReleaseWorker::class,
			SetCurrentMutualDependenciesReleaseWorker::class,
			AddTagToChangelogReleaseWorker::class,
			SetNextMutualDependenciesReleaseWorker::class,
			UpdateBranchAliasReleaseWorker::class,
			PushNextDevReleaseWorker::class
		]);
	} elseif(preg_match('/^[0-9]+\.[0-9]+\.[0-9x]+-dev/', $version)) {
		/**
         * 開発版
		 * タグは送信しない
         */
		$mbConfig->defaultBranch($version);
		$mbConfig->disableDefaultWorkers();
		$mbConfig->packageAliasFormat('<major>.<minor>.x-dev');
		$mbConfig->workers([
			PushNextDevReleaseWorker::class
		]);
    } elseif(preg_match('/^[0-9]+\.[0-9]+\.[0-9]+-(alpha|beta|rc)/', $version)) {
    	/**
         * alpha / beta / rc
         * タグの送信のみ
         */
    	$mbConfig->defaultBranch('dev');
    }
};
