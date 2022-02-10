let list= [
    {id: 1, name: 'aa', is_parent: 1, parent_id: 0, level: 1},
    /**/{id: 2, name: 'bb', is_parent: 0, parent_id: 1, level: 2},
    /**/{id: 3, name: 'cc', is_parent: 0, parent_id: 1, level: 2},

    {id: 4, name: 'dd', is_parent: 1, parent_id: 0, level: 1},
    /**/{id: 5, name: 'ee', is_parent: 0, parent_id: 4, level: 2},
    /**/{id: 6, name: 'ff', is_parent: 1, parent_id: 4, level: 2},
    /**//**/{id: 7, name: 'gg', is_parent: 0, parent_id: 6, level: 3},

    {id: 8, name: 'hh', is_parent: 1, parent_id: 0, level: 1},
    /**/{id: 9, name: 'ii', is_parent: 0, parent_id: 8, level: 2},

    {id: 10, name: 'jj', is_parent: 1, parent_id: 0, level: 1},
    /**/{id: 11, name: 'kk', is_parent: 1, parent_id: 10, level: 2},
    /**//**/{id: 12, name: 'll', is_parent: 1, parent_id: 11, level: 3},
    /**//**//**/{id: 13, name: 'mm', is_parent: 0, parent_id: 12, level: 4},
]


function setGroups(list) {
    const getTree = (data, root) => {
            const t = {};
            list.forEach(o => ((t[o.parent_id] ??= {}).children ??= []).push(Object.assign(t[o.id] ??= {}, o)));
            return t[root].children;
        },
        data = {People: []},
        result = Object.fromEntries(Object
            .entries(data)
            .map(([k, v]) => [k, getTree(v, '0')])
        );

    //console.log(result);
    return result;
}
function setGroups2() {
    var data = [
            {ID: 12, NAME: "ktc", PARENTID: 0},
            {ID: 11, NAME: "root", PARENTID: 0},
            {ID: 1, NAME: "rwhitney", PARENTID: 0},
            {ID: 21, NAME: "shared folder", PARENTID: 0},
            {ID: 13, NAME: "efast", PARENTID: 12},
            {ID: 2, NAME: ".config", PARENTID: 1},
            {ID: 5, NAME: "wallpapers", PARENTID: 1},
            {ID: 15, NAME: "includes", PARENTID: 13},
            {ID: 14, NAME: "views", PARENTID: 13},
            {ID: 3, NAME: "geany", PARENTID: 2},
            {ID: 17, NAME: "css", PARENTID: 15},
            {ID: 16, NAME: "js", PARENTID: 15},
            {ID: 4, NAME: "colorschemes", PARENTID: 3}
        ],
        tree = function (data, root) {
            var t = {};
            data.forEach(o => {
                Object.assign(t[o.ID] = t[o.ID] || {}, o);
                t[o.PARENTID] = t[o.PARENTID] || {};
                t[o.PARENTID].children = t[o.PARENTID].children || [];
                t[o.PARENTID].children.push(t[o.ID]);
            });
            return t[root].children;
        }(data, 0);

    console.log('tree', tree);
}

let tree = setGroups(list);
console.log('tree:', tree);
