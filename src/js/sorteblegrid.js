document.addEventListener('DOMContentLoaded', () => {
    const orderNumberOfTile = Array.from(document.querySelectorAll(".orderNumber"));
    const placeholder = document.querySelector('.placeholder-tile');
    let draggedTile = null, offsetX = 0, offsetY = 0;
    let isDragging = false;
    let tiles = Array.from(document.querySelectorAll('.tile'));

    const onMouseDown = (e) => {
        if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
            return;
        }

        tiles = Array.from(document.querySelectorAll('.tile')).filter(tile => tile.querySelector("img"));
        e.preventDefault();

        draggedTile = tiles.find(tile => tile.contains(e.target));
        if (!draggedTile) return;

        const rect = draggedTile.getBoundingClientRect();
        if (e.type === 'touchstart') {
            offsetX = e.touches[0].clientX - rect.left;
            offsetY = e.touches[0].clientY - rect.top;
        } else {
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
        }

        isDragging = true;
        draggedTile.classList.add('dragging');
        placeholder.style.display = 'block';
        placeholder.style.order = draggedTile.style.order;

        moveDraggedTile(e);  // Move the tile to the initial position immediately

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
        document.addEventListener('touchmove', onMouseMove);
        document.addEventListener('touchend', onMouseUp);
    };

    const moveDraggedTile = (e) => {
        if (draggedTile) {
            if (e.type === 'touchmove' || e.type === 'touchstart') {
                draggedTile.style.left = `${e.touches[0].clientX - offsetX}px`;
                draggedTile.style.top = `${e.touches[0].clientY - offsetY + window.scrollY}px`;
            } else {
                draggedTile.style.left = `${e.clientX - offsetX}px`;
                draggedTile.style.top = `${e.clientY - offsetY + window.scrollY}px`;
            }
        }
    };

    const updateOrderNumbers = () => {
        const tiles = document.querySelectorAll(".tile");
        tiles.forEach((tile, index) => {
            const order = parseInt(tile.style.order);
            orderNumberOfTile[index].innerHTML = order;
        });
    };

    const onMouseMove = (e) => {
        e.preventDefault();
        if (!isDragging) return;
        moveDraggedTile(e);

        const rect = draggedTile.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        let newOrder = null;

        tiles.forEach(tile => {
            if (tile !== draggedTile) {
                const tileRect = tile.getBoundingClientRect();
                if (centerX > tileRect.left && centerX < tileRect.right &&
                    centerY > tileRect.top && centerY < tileRect.bottom) {
                    newOrder = tile.style.order;
                }
            }
        });

        if (newOrder !== null && newOrder !== placeholder.style.order) {
            const oldOrder = placeholder.style.order;
            placeholder.style.order = newOrder;

            tiles.forEach((tile) => {
                const tileOrder = parseInt(tile.style.order);
                if (tileOrder >= newOrder && tileOrder < oldOrder) {
                    tile.style.order = tileOrder + 1;
                } else if (tileOrder <= newOrder && tileOrder > oldOrder) {
                    tile.style.order = tileOrder - 1;
                }
            });
        }

        draggedTile.style.order = placeholder.style.order;
        const draggedTileIndex = tiles.indexOf(draggedTile);
        orderNumberOfTile[draggedTileIndex].innerHTML = placeholder.style.order;

        updateOrderNumbers();
    };

    const onMouseUp = () => {
        if (draggedTile) {
            draggedTile.classList.remove('dragging');
            draggedTile.style.left = '';
            draggedTile.style.top = '';
            draggedTile.style.order = placeholder.style.order;

            updateOrderNumbers();

            draggedTile = null;
            placeholder.style.display = 'none';
            isDragging = false;
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            document.removeEventListener('touchmove', onMouseMove);
            document.removeEventListener('touchend', onMouseUp);
        }
    };

    tiles.forEach(tile => {
        tile.addEventListener('mousedown', onMouseDown);
        tile.addEventListener('touchstart', onMouseDown, { passive: false });
    });

    updateOrderNumbers();
});
