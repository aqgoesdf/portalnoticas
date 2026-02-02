from django.contrib import admin

#confirações para as cotegorias é as noticias
from .models import Noticia, Categoria

# chamada das funções categorias é noticias.
admin.site.register(Noticia)
admin.site.register(Categoria)
