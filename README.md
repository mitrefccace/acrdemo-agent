# Agent Portal
### This is the Agent Portal.

## Installation on the Linux AWS instance:
1. Clone this repository into /var/www/html/agent
1. Run the db/agent_data.sql script (MySQL user: user, pass: password)
1. Start MySQL (if down): sudo /etc/init.d/mysql start
1. Restart Apache: sudo service apache2 restart
1. Test: http://localhost/agent/ (default login: user/password, admin login: user2/password2)

## Configuration
1. Edit database parameters in the config.ini file

## Environment
1. LAMP

# Agent Portal (aserver)
The ASERVER is part of the Agent Portal source code. See the aserver folder for installation/configuration details.

