

#Criar rota principal, aquivo de rota não criado
from django.urls import path
from . import views

urlpatterns = [
    path('', views.home, name='home')
]