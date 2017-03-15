# Change Log for wpDataTables Module

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased]

Nothing documented right now.

## [1.1.0] - 2017-03-15

### Changed

- Entity attribute for row columns to automatically detect:
  - Float columns as being the `decimal_number` data type.
  - Datetime columns as being the `mysql_datetime` data type.

## [1.0.1] - 2017-03-11

### Fixed

- Fatal errors when the wpDataTables plugin is not activated. #5

## [1.0.0] - 2017-01-04

### Added

- Add Row to Table hook event.
  - Fires when a row is added to a table, reverses when it is deleted.
  - Automatically registered for every editable table.
- Row entity.
  - Attributes are automatically registered, and text and integer data types automatically detected.
  - Relationship to a user is automatically registered.
- PHPUnit factory for tables to use in the tests.

[unreleased]: https://github.com/WordPoints/wpdatatables/compare/master...HEAD
[1.1.0]: https://github.com/WordPoints/wpdatatables/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/WordPoints/wpdatatables/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/WordPoints/wpdatatables/compare/...1.0.0
