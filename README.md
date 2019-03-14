
# yProjectGuardian
[YeAPF](http://www.YeAPF.com "YeAPF") application that helps you to upload a project to a repository and keep applications up to date.

We have been struggling with git updates of slave servers (not by git issues but because our costumers decided to block this service) so we develop this single application based in php, curl, zip and crontab.

The idea is to keep all the slave servers up to date when an update has been released.

## How it works
![enter image description here](http://yeapf.com/images/mermaid-yProjectGuardian-how-it-works.svg?v=1)

## TL;DR
In case you want to go to the hot stuff, just jump to "putting the stuff to work" section.

### Definitions
Let's say there is a source machine where the code has been tested and versioned and ready to deploy to production. We will call this machine *source*

Let's say ther is a set of servers that need to be updated after a change in the *source*. We will call every one of these machines *target*

And you will have a repository server that will be named as *repo*

### Prerequisites
1. [Curl](https://curl.haxx.se/) need to be installed.
	`$ apt-get install curl -y`
2. You need to have the [YeAPF](http://bit.ly/downloadYeAPF) tools installed in your *source* machine.
(YeAPF tools are not necessary to develop your software neither in *repo* machine)

    	a. Download YeAPF from http://bit.ly/downloadYeAPF
    	b. Unzip it
    	c. Enter into tools folder
    	d. Run install.sh as super user
    	e. Enter into tools/distributionBuilder
    	f. Run install-ydistbuilder.sh as super user

## Configuration of the players
The main work will happen in the *source*  machine as it will be used to develop and versionate the software you're building.

#### Source machine

Let's say you have a project in *~/www/myProject*

It can be or not a YeAPF project. (I.E. you can be developing with Laravel and using YeAPF just to distribute your code)

Anyway, you need to create *version.inf*, *ydistbuilder.copyright* and *ydistbuilder.files* as in these examples:

*version.inf*

    0.1.2

*ydistbuilder.copyright*

    "Copyright (C) 2017-".date('Y')." Example Inc."

*ydistbuilder.files*


    *.html
    img/*
    css/*
    js/*
    customers/*
    docs/*

Once it's done, you can build a new distribution:

    ydistbuilder

And, of course, after some time you will make some changes in your sources and will want to release an update of the same version:

    ydistbuilder --update

Both of them accept *--silent* parameter in order to keep the console quiet.

Each time you use *ydistbuilder* it will copy all your project into *.distribution* folder and create a *.zip* file that will be left at *downloads* folder. Both of these folders are at the same location of *ydistbuilder.files*, *version.inf* and *ydistbuilder.copyright*

In the *source* machine you need to create a yproject.ini file into the *etc* folder into your project. **You can use /etc too if you have only one project at your machine** 
Here is an example.

        [project]
        source=http://distro.example.com.br/
        id=myLittleProject
        license=3aa123217f32d97b55b371fa37e2c236

#### Repo machine
The *repo* machine is a web sever (LAMP, WAMP, MAMP, whatever) that will receive and keep your project updates. Of course that it will need to have DNS and other stuff well configured.

In our sample, we will put our uploader in a folder called "projects", so */var/www/html/projects* will illustrate a common folder used for that.

All this project will be putted in this folder, and -as in any YeAFP application- you will need to adjust *yeapf.db.ini*. As it does not need database connection a good sample is the next:

    [yProjectGuardian]
    active=1
    appRegistry=b30cc15b3504354b137dc571bec4e30b
    appName=yProjectGuardian application
    appLang=en
    cfgJumpToBody=1
    cfgHtPasswdRequired=no
    cfgHttpsRequired=no
    dbConnect=no
    dbOnline=05:00-20:40
    ...
Obviously you need to configure this application. So if your server answers under distro.example.com and the folder is *projects* you will need to call *http://distro.example.com/projects/configure.php* if your folder is with the correct rights, you will not face any problem. 

Meanwhile, is good to note that *uploadProject.php* not need YeAPF in order to run. So if you need to use just to upload your projects or you face some strange difficulties doing configure.php, you still will be able to upload them.

#### Target machine(s)
Now is time to configure each target machine.

In order to download a project, it requires a *yproject.ini* file as in the next sample:

    [project]
    source=http://distro.example.com/projects/
    id=myLittleProject
    backup=/var/www/backup/myLittleProject
    folder=/var/www/html/
    license=3aa123217f32d97b55b371fa37e2c236

Again, it can be at */etc* folder but if you have more than one project, you will would like to put *yproject.ini* in your project etc folder.

In the sample, we decided to put our backup in */var/www/backup/myLittleProject* folder while the application folder is */var/www/html*. Easily you can see that we're using this machine for host only one project. In other words, say your domain is *example.com* and this server is *srv1* navigate to https://srv1.example.com will direct you to the content in */var/www/html*

The purpose of the *backup* folder is to keep a well done copy of the project as the programmer wants it to be deployed. In case a bad intentioned user/software change the content of */var/www/html*, **yProjectGuardian** will use this copy to overwrite the bad stuff in the main folder.


## Doing the stuff work
#### On the source machine:
1. Use *ydistbuilder* to create a new version or update the current one
2. Use *yuploader* to upload the current version to the repo
#### On the target machine:
1. Use *ydownloader* to check the installed version of your software and download it if necessary.
2. Put *ydownloader* to work on regular basis using **crontab** as in this sample:


    55 23 * * * /bin/bash /var/www/html/ydownloader

In this case, your application version will be checked each day at 23:55 using the bash script

Another possibility is to use the php script with crontab as this:

    55 23 * * * /usr/local/bin/php /usr/local/bin/yprojectguardian --config /var/www/html/yproject.ini
