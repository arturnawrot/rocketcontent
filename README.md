# rocketcontent.io

Content on demand SaaS with monthly or annual subscription required.




## Installation

Use docker to run the project

```bash
docker-compose up -d
docker exec -it php-rocketcontent make install
```
### Troubleshooting common problems
`No releases available for package "pecl.php.net/xdebug"`

It's not our fault. Pecl servers have some issues with connectivity and you will have to try to rebuild another time, or you can use a VPN (Frankfurt, Germany worked flawlessly for me).
