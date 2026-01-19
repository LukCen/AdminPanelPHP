let page = 2



function loadMoreGames(game) {
  const card = document.createElement('div');
  card.className = 'card flex flex-col gap-2 items-center rounded-xl p-2 bg-secondary'

  card.innerHTML = `
    <img height="200" width="200" src="${game.background_image ?? 'https://placehold.co/300x300'}" alt="">
  <div class="text flex flex-col flex-auto justify-around items-center gap-2">
    <h2>${game.name}</h2>
    <p>Released: ${game.released}</p>
    <a href='${game.slug}'></a>
    <a href='?view=game_page&game=${game.slug}' class="btn bg-light text-primary px-2 py-1 max-w-fit text-center font-bold">Go to game page &rarr; </a>
 
  </div>
  <a data-id='${game.id}' class='btn dbc bg-primary px-2 py-2 w-fit font-bold'>Add to database</a>
   <span data-id= '${game.id}' class="hidden database-add-marker bg-light px-4 py-1 text-center font-bold">Added to database!</span>
  `

  document.querySelector('main .content').appendChild(card)
}

async function getDataFromEndpoint() {
  try {
    const res = await fetch(`../api/GetMoreGames.php?page=${page}`)
    const data = await res.json()

    data.results.forEach(loadMoreGames);

    page++
  } catch (err) {
    console.error(`Failed to load more games for page ${page++}, error: ${err}.`)
  }
}

document.querySelector('button.load-more').addEventListener('click', getDataFromEndpoint)

