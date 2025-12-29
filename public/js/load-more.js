let page = 1

function loadMoreGames(game) {
  const card = document.createElement('a');
  card.href = `?view=game_page&game=${game.slug}`
  card.className = 'card flex flex-col gap-2 items-center p-2 bg-secondary'

  card.innerHTML = `
    <img height="200" width="200" src="${game.background_image ?? 'https://placehold.co/300x300'}" alt="">
  <div class="text flex flex-col gap-2">
    <p>Name: ${game.name}</p>
    <p>Date of release: ${game.released}</p>
    <button class="bg-light px-2 py-1 w-fit font-bold">Go to game page &rarr; </button>
  </div>
  `

  document.querySelector('main .content').appendChild(card)
}

async function getDataFromEndpoint() {
  try {
    const res = await fetch(`../api/GetMoreGames.php?page=${page}`)
    const data = await res.json()

    console.log(data)
    data.results.forEach(loadMoreGames);
    page++
  } catch (err) {
    console.error(`Failed to load more games for page ${page++}, error: ${err}.`)
  }
}



document.querySelector('button.load-more').addEventListener('click', getDataFromEndpoint)
