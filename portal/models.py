from django.db import models

# Categorias.
class Categoria(models.Model):
    nome = models.CharField(max_length=100)

    def __str__(self):
        return self.nome
    
# Noticias
class Noticia(models.Model):
    titulo = models.CharField(max_length=200)
    resumo = models.TextField()
    conteudo = models.TextField()
    imagem = models.ImageField(upload_to='noticas/', blank=True, null=True)
    categoria = models.ForeignKey(Categoria, on_delete=models.CASCADE)
    destaque = models.BooleanField(default=False)
    criado_em = models.DateTimeField(auto_now=True)


    def __str__(self):
        return self.titulo