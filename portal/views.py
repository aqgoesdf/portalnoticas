from django.shortcuts import render
from .models import Noticia

def index(request):
    destaque = Noticia.objects.filter(destaque=True).first()
    secundarias = Noticia.objects.filter(destaque=False)[:3]
    ultimas = Noticia.objects.order_by('-criado_em')[:5]


    context = {
        'destaque': destaque,
        'secundarias': secundarias,
        'ultimas': ultimas
    }

    return render(request, 'portal/index.html', context)

# Create your views here.
