// Simulação de transição de carrossel
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');

nextBtn.addEventListener('click', () => {
    console.log("Próxima notícia...");
    // Aqui entrará a lógica de transição suave
});

// Interação de Hover com Ícones Modernos
document.querySelectorAll('.mini-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.borderColor = 'var(--primary)';
    });
    card.addEventListener('mouseleave', () => {
        card.style.borderColor = 'transparent';
    });
});

// Exemplo de como os dados virão do Back-end futuramente
const fetchNews = async () => {
    // const response = await fetch('api/news');
    // const data = await response.json();
    console.log("Sistema pronto para receber JSON do Python/Node.js");
};