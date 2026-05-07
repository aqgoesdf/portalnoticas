from flask import Flask, render_template

#inicializa o aplicativo
app = Flask(__name__)

# Rota principal: Onde as noticias serão exibidas 
@app.route('/')
def home():
    return render_template('index.html')

if __name__ == '__main__':
    #debug=true faz o servidor reinicar sozinho a cada alteração
    app.run(debug=True)