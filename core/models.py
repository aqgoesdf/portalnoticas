from django.db import models

# Create your models here.
class Post(models.Model):
    titulo = models.CharField(max_length=200)
    conteudo = models.TextField()
    imagem = models.ImageField(upload_to='posts/', blank=True, null=True)
    data_criacao = models.DateTimeField(auto_now_add=True)


def __str__(self):
    return self.titulo


