from django.contrib import admin

# Register as noticias é as categorias.
from .models import Noticas, Categoria

admin.site.register(Noticas)
admin.site.register(Categoria)