from django.conf.urls import url
from django.contrib import admin
import mysite.views

urlpatterns = [
    url(r'^admin/', admin.site.urls),
    url(r'^$', mysite.views.index,name='index'),
    url(r'^hello/$', mysite.views.hello,name='hello'),
    url(r'^base/$', mysite.views.base,name='base'),
    url(r'^login/$', mysite.views.user_login,name='login'),
    url(r'^logout/$', mysite.views.user_logout,name='logout'),
    url(r'^time/$', mysite.views.time,name='time'),
]

