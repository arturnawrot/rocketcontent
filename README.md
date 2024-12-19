# SaaS Stripe Boilerplate

### Features

- [x] Login and registration system.
- [x] Monthly subscriptions, including a free trial period.
- [x] Addition and removal of credit cards.
- [x] Subscription is automatically paused in the event of a failed payment or chargeback.
- [x] Flawless synchronization between the local database and Stripe with proper caching.
- [x] Integration tests cover all advanced Stripe use cases, such as handling chargebacks, preventing duplicate credit card entries, and ensuring the proper expiration of free trial periods.

## Installation

Use docker to run the project

```bash
docker-compose up -d
docker exec -it php-rocketcontent make install
```
### Run tests
```bash
docker exec -it php-rocketcontent make test
```
### Create first admin account
```bash
docker exec -it php-rocketcontent php artisan command:create-admin-account

What's your valid email address? (need to verify before you can log in):
 > john@doe.com     

Admin account created.
Login: john@doe.com
Password: ******* (you can change the password later in the admin panel)
```
### Update .env with your Stripe keys
```
STRIPE_KEY=
STRIPE_SECRET=
```
### Troubleshooting common problems
`No releases available for package "pecl.php.net/xdebug"`

It's not our fault. Pecl servers have some issues with connectivity and you will have to try to rebuild another time, or you can use a VPN (Frankfurt, Germany worked flawlessly for me).

## Screenshots

![Main page](https://github.com/arturnawrot/rocketcontent/blob/master/screenshots/rocketcontent-front.PNG?raw=true)

![Dashboard](https://github.com/arturnawrot/rocketcontent/blob/master/screenshots/dashboard.PNG?raw=true)

