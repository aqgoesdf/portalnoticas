from django.db import models

# Categoerias.
class Categoria(models.Model):
    nome = models.CharField(max_length=200)

    def __str__(self):
        return self.nome
    

#Noticas
class Noticas(models.Model):
    titulo = models.CharField(max_length=200)
    resumo = models.TextField()
    imagem = models.ImageField(upload_to='noticia/')
    categoria = models.ForeignKey(Categoria, on_delete=models.CASCADE)
    destaque = models.BooleanField(default=False)
    data_publicacao = models.DateField(default=False)


    def  __str__(self):
        return self.titulo