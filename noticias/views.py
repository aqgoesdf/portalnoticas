from django.shortcuts import render

# Lógina no portal
from .models import Noticas, Categoria

def index(request):
    categorias = Categoria.objects.all()
    noticias = Noticas.objects.all().order_by('-data_publicacao')
    destaque = noticias.filter(destaque=True).first()

    context = {
        'categorias': categorias,
        'noticias': noticias,
        'destaque': destaque,
    }
    return render(request, 'noticias/index.html', context)