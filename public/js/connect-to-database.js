/**
 * Calls an API endpoint, depending on the action parameter, and prepares UX elements for the correct element.
 * @param {string} action - Action to execute ("add", "remove")
 * @param {string[]} value - data-id parameter of the element on which to execute the endpoint
 * @returns {void} 
 */
export async function callDb(action, value) {
  let db;
  let loader;
  let marker;
  const dbBadge = document.querySelector(`.card[data-id="${value}"] .badge-favourite`);

  try {
    console.log(action, value)
    // values and endpoints depending on action param - expand if needed
    switch (action) {
      case "add":
        loader = document.querySelector(`.dbc[data-id="${value}"] .lucide-loader-icon`)
        loader.classList.remove('hidden')
        db = await fetch('../api/AddRowToDatabase.php', {
          method: "POST",
          body: value
        });
        marker = document.querySelector(`.card[data-id="${value}"] .database-add-marker`)
        // console.log('adding')
        break;
      case "remove":
        loader = document.querySelector(`.dbr[data-id="${value}"] .lucide-loader-icon`)
        loader.classList.remove('hidden')
        db = await fetch('../api/RemoveRowFromDatabase.php', {
          method: "POST",
          body: value
        })
        marker = document.querySelector(`.card[data-id="${value}"] .database-remove-marker`)
        break;
    }

    const data = await db.json()

    // todo - clear old markers so we dont get two
    if (data.success) {
      // show/hide badge depending if game gets added/removed
      if (action === "add" && dbBadge.classList.contains('hidden')) {
        dbBadge.classList.replace('hidden', 'flex')
      } else if (action === "remove" && dbBadge.classList.contains('flex')) {
        dbBadge.classList.replace('flex', 'hidden')
      }

      // show the added/removed marker after successful database query
      if (marker) {
        marker.classList.toggle('hidden')
        setTimeout(() => {
          marker.classList.toggle('hidden')
        }, 3000)
      }
    }
  }
  catch (err) {
    throw new Error(`Removing from database unsuccessful: ${err}.`)
  }
  // clear loader after query ends
  finally {
    loader.classList.add('hidden')
  }
}
