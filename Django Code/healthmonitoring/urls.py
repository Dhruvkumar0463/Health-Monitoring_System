from django.contrib import admin
from django.urls import path, include

urlpatterns = [
    path('admin1/', admin.site.urls),
    path('', include('new.urls')),
]