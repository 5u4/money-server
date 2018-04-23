<p align="center"><img src="https://github.com/senhungwong/money-server/blob/master/docs/logo/logo.png"></p>

## Description

The project is a [Laravel](https://laravel.com/) back-end accounting tool.

## Features

### Authentication

The tool uses Json web token as an authentication method. It also tracks the last login IP address and prevents access token been stolen. 

### Transaction

A user can record transaction related to a wallet, a store and a service.

### Log

User can see all the actions done through log.

## API

 - [General](api/general.md)

## Deployment

1. Make sure [Neo4J](https://neo4j.com/) and a relational database is set.

2. Rename [.env.example](.env.example) to `.env` and fill out the database credentials

3. Install Dependencies

```bash
$ composer install
```

4. Migration

```bash
$ php artisan migrate
```
