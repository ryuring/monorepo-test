# Monorepo Test

開発版を composer でインストールするためのテストリポジトリです。

## 開発版のリリース
1.0.x のような開発バージョンのブランチ名を作成し push します。 

```bash
git checkout -b 1.0.x
git push origin 1.0.x
```

取得する際は、ブランチから取得する前提として、次のようにします。

```bash
composer require monorepo/monorepo-child-test:1.0.x
```

## アルファ、ベータ、RC版のリリース
アルファ、ベータ、RC版をリリースする場合は、次のようにします。  
開発ブランチとタグが更新されます。

```bash
bin/vendor/monorepo-buulder release 1.0.0-alpha
bin/vendor/monorepo-buulder release 1.0.0-beta
bin/vendor/monorepo-buulder release 1.0.0-rc
```

取得する際は、タグから取得する前提として、次のようにします。

```bash
composer require monorepo/monorepo-child-test:1.0.0-alpha
composer require monorepo/monorepo-child-test:1.0.0-beta
composer require monorepo/monorepo-child-test:1.0.0-rc
```

