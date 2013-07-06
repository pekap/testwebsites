from django.db import models
from django.contrib.auth.models import User

class UserProfile(models.Model):
    # Every person who uses the website. Is usually connected with a User, but can work without an associated User
    authUser = models.OneToOneField(User, unique=True, null=True)
    email = models.EmailField()

class Greeting(models.Model):
    curator = models.ForeignKey('UserProfile', related_name='greeting_curator')
    recipient = models.ForeignKey('UserProfile', related_name='greeting_recipient')
    invitees = models.ManyToManyField('UserProfile', related_name='greeting_invitees')

class Video(models.Model):
    videoFile = models.FileField(upload_to='videos')
    greeting = models.ForeignKey('Greeting')
    creator = models.ForeignKey('UserProfile')
