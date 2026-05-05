from django.shortcuts import render

# Editado por aparti daqui.
def home(request):
    return render(request, 'core/base.html')
