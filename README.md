#### 📖 manaSQL

### Descirption

A lightweight PHP Script for managing MySQL database connections <br/> through fully responsive UI using TailwindCSS + Alpine.js

### Preview

<img width="60%" style="border-radius:12px" src="https://raw.githubusercontent.com/nastasagr/manaSQL/refs/heads/main/preview.png">

## Features

- Connect to a MySQL database
- List available database tables
- Drop the current database
- Logout and destroy PHP session
- Session check to verify connection info

## API Endpoints

The main API is **requests.php**

Available requests endpoints:

| Endpoint              |         Action          |  Method |
| --------------------- | :---------------------: | ------: |
| ?request=connect      |     Handle connect      | **GET** |
| ?request=tables       | Handle fetching tables  | **GET** |
| ?request=dropDatabase | Handle droping database | **GET** |
| ?request=logout       |      Handle logout      | **GET** |
| ?request=sessionCheck |    Checking session     | **GET** |

## Requirements

- PHP 7.4+
- MySQL/MariaDB
- Sessions enabled in php.ini

## ⚠️ Be Careful

- This tool was built for my personal needs.
- Do not expose it to production without proper authentication.

## Improvements

- Droping DB must send POST or DELETE request.
- Generate Logs for every action.

#### Feel free to contribute

Pull requests, suggestions, and improvements are always welcome!
