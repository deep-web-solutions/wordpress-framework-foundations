# How to test the package

## Setup

1) Create a WordPress test instance. You can use your preferred method of setting up development environments, e.g. VVV, Docker, Local by Flywheel etc.
1) Create a separate database for acceptance+functional tests. For example, for `DB_USER` 'wp' and `DB_HOST` 'localhost':

    * mysql -u root -p -e "CREATE DATABASE if not exists foundations_tests"
    * mysql -u root -p -e "GRANT ALL PRIVILEGES ON foundations_tests.* TO 'wp'@'localhost';"

1) Modify the `wp-config.php` file to use the appropriate database for acceptance and functional tests: https://wpbrowser.wptestkit.dev/tutorials/vvv-setup#using-the-tests-database-in-acceptance-and-functional-tests
1) Copy the `_support/dws-wp-foundations-test-plugin` folder to your instance's `wp-content/plugins` folder and install dependencies with `composer install --ignore-platform-reqs`.
1) Set the starting database fixture: https://wpbrowser.wptestkit.dev/tutorials/vvv-setup#setting-up-the-starting-database-fixture
1) Copy the `.dist.env` file to `.env.testing` and fill in your local environment variables.
1) Copy the `codeception.local.yml` file to `codeception.yml` and adjust, if needed.


## Running Tests

#### Integration tests

From the test plugin's directory, run `./vendor/bin/codeception run wpunit` or `composer run-script test:integration`.

#### Functional tests

From the test plugin's directory, run `./vendor/bin/codeception run functional` or `composer run-script test:functional`.
