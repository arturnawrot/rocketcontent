# rocketcontent.io

Content on demand SaaS with monthly or annual subscription required.




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
