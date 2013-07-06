from django.conf.urls import patterns, include, url
import settings

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'videoroast.views.home', name='home'),
    # url(r'^videoroast/', include('videoroast.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

     url(r'^admin/', include(admin.site.urls)),

     url(r'^$','videoroast.views.index',name='mainpage'),
     url(r'^greetingpage/$', 'videoroast.views.greetingpage'),
     url(r'^greetingpage/start/$','videoroast.views.greetingpage_start',name='start'),
     url(r'^greetingpage/record/$','videoroast.views.greetingpage_record',name='record'),
     url(r'^greetingpage/invite/$','videoroast.views.greetingpage_invite',name='invite'),
     url(r'^greetingpage/compose/$','videoroast.views.greetingpage_compose',name='compose'),
)
