from django.shortcuts import render

# Editado por aparti daqui.
from .models import Post

def home(request):
    posts = Post.objects.all().order_by('-data_criacao')
    destaque = posts.first()  # primeiro post como destaque
    outros_posts = posts[1:]  # restante

    return render(request, 'core/home.html', {
        'posts': outros_posts,
        'destaque': destaque
    })

