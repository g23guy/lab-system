# spec file for package lab-system
#
# Copyright (c) 2014 SUSE LLC
#
# This file and all modifications and additions to the pristine
# package are under the same license as the package itself.
#

%define labname labsystem
%define webname lab

Name:         lab-system
Summary:      Gathers basic server information
URL:          https://github.com/g23guy/lab-system
Group:        Productivity/Databases/Tools
License:      GPL-2.0
Autoreqprov:  on
Version:      0.1
Release:      1
Source:       %{name}-%{version}.tar.gz
BuildRoot:    %{_tmppath}/%{name}-%{version}
Buildarch:    noarch
Requires:     php5

%description
A simple lab machine check out system.

Authors:
--------
    Jason Record <jrecord@suse.com>
 
 
%prep
%setup -q

%build
#gzip -9f man/*8

%install
pwd;ls -la
rm -rf $RPM_BUILD_ROOT
install -d $RPM_BUILD_ROOT/etc/opt/%{labname}
install -d $RPM_BUILD_ROOT/opt/%{labname}/bin
install -d $RPM_BUILD_ROOT/usr/share/doc/packages/%{labname}
install -d $RPM_BUILD_ROOT/var/spool/%{labname}
install -d $RPM_BUILD_ROOT/srv/www/htdocs/%{webname}/images
install -m 644 conf/* $RPM_BUILD_ROOT/etc/opt/%{labname}
install -m 444 man/COPYING.GPLv2 $RPM_BUILD_ROOT/usr/share/doc/packages/%{labname}
install -m 444 schema/* $RPM_BUILD_ROOT/usr/share/doc/packages/%{labname}
install -m 755 bin/* $RPM_BUILD_ROOT/opt/%{labname}/bin
install -m 644 web/* $RPM_BUILD_ROOT/srv/www/htdocs/%{webname}
install -m 644 images/* $RPM_BUILD_ROOT/srv/www/htdocs/%{webname}/images

%files
%defattr(-,root,root)
%dir /opt/%{labname}
%dir /opt/%{labname}/bin
/opt/%{labname}/bin/*
%dir /etc/opt/%{labname}
%config /etc/opt/%{labname}/*
%dir %attr(-,wwwrun,www) /srv/www/htdocs/%{webname}
%dir %attr(-,wwwrun,www) /srv/www/htdocs/%{webname}/images
%attr(-,wwwrun,www) /srv/www/htdocs/%{webname}/*
%attr(-,wwwrun,www) /srv/www/htdocs/%{webname}/images/*
%dir /usr/share/doc/packages/%{labname}
%doc /usr/share/doc/packages/%{labname}/*

%changelog

