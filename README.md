MultiBIND Admin
===============

[![Project Status: Inactive - The project has reached a stable, usable state but is no longer being actively developed; support/maintenance will be provided as time allows.](http://www.repostatus.org/badges/0.1.0/inactive.svg)](http://www.repostatus.org/#inactive)

MultiBIND Admin is a web-based BIND DNS zone file administration tool written in
PHP. It manages forward and reverse DNS as well as most common record types
(though it is currently IPv4 only). Its main feature is understanding of NATed
split-horizon environments, where each record is stored with separate internal
and external view addresses, and these are automatically mapped to the
appropriate views. 

This collection of scripts manages DNS in a MySQL database, and then the
bin/multibind-update.php script is run on the master BIND server to pull down
data for and re-write all changed zone files.

I used this project for internal DNS for my home network and sites for about
three years, and it served me quite well.
