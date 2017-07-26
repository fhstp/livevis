//var width = $(window).width();
//var height = $(window).height() - 5;

var width = $('.bubbleContainer').width();
var height = ($('.bubbleContainer').height() - 5);

var blue = '#1f77b4';
var orange = '#ff7f0e';
var green = '#2ca02c';
var red = '#d62728';
var purple = '#9467bd';
var black = '#000000';
var white = '#FFFFFF';

var nodes = [];
var votesTexts = [];
var bubbleCols = [blue, orange, green, red, purple];

var bubbleRadius = 20;
var strokeWidth = 4;
var bubbleDistance = 5.5;
var scaleWidth = 0.8;

// Data
var ctvData = {};
var questionKeyword = 0;

// Answers
var numAnswers = {};
var answersIndex = {};
var answersCenters = {};

// Graphics
var svgContainer = 0;
var bubble = 0;
var keyword = 0;
var voteText = 0;

// Force
var charge = 0;
var force = 0;

// Chart
var numVotesAnswer = [];
var prevNumVotesAnswer = [];
var visStart = false;
var isScaling = false;

var setup = false;
var isActive = true;
var dragging = false;


// Is Browser Tab active?
window.onfocus = function () {
    isActive = true;
};

window.onblur = function () {
    isActive = false;
};


/********
 * DATA *
 ********/

updateCtvData();

function updateCtvData() {
    // Start the ajax request to receive data from database.
    var questionId = $('#question_id').val();
    var ajaxRequest = $.ajax({
        // routes.php knows this url and returns the right controller
        url: "/bubbleViz/"+questionId+"/ajaxHandler",
        // the data comes straight from the bubbleViz - View
        // you will need the question id to receive the right data for your current question
        type: 'get',
        dataType: 'json',
        success: function (data) {
            if (!setup) setupBubbleViz(data);
            if (setup) updateBubbleViz(data);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

function setupBubbleViz(data) {

    setup = true;

    /********
     * DATA *
     ********/

    ctvData = data[1];
    questionKeyword = data[0];

    /***********
     * ANSWERS *
     ***********/

    // Get number of answers
    numAnswers = Object.keys(ctvData).length;

    // Get index numbers of Answers
    answersIndex = Object.getOwnPropertyNames(ctvData);

    // Object for proper adjustment of bubbles
    answersCenters = {};


    ////// SCALING //////

    // Amount of percent for each answer
    var partPercent = 0;

    // Scaling-Factor depending on number of answers
    switch (numAnswers) {
        case 1:
            partPercent = 1;
            break;
        case 2:
            partPercent = 0.5;
            break;
        case 3:
            partPercent = 0.333333;
            break;
        case 4:
            partPercent = 0.25;
            break;
        case 5:
            partPercent = 0.2;
            break;
        default:
            partPercent = 0;
            break;
    }

    var widthVis = width * scaleWidth;

    // X-Offset left and right of the screen
    var start = (width - widthVis) / 2;
    var counterPercent = 0;

    // Determine answerCenters
    for (i = 0; i < numAnswers; i++) {
        // Fill answersCenter-Object width center-position of each answer in relation
        // to the screen-size (= Locations to move bubblesData towards)

        answersCenters[i] = {
            x: start + ((widthVis * partPercent) / 2) + (widthVis * counterPercent),
            y: height / 2
        };

        // Number of votes per answer
        numVotesAnswer[i] = ctvData[i].votesPercent;

        votesTexts[i] = {
            votes: numVotesAnswer[i],
            col: bubbleCols[i],
            x: answersCenters[i].x
        };
        counterPercent += partPercent;
    }


    /*******
     * SVG *
     *******/

    // Add SVG to vis-div
    svgContainer = d3.select('#vis').append('svg')
        .attr('width', width)
        .attr('height', height);

    ////// BUBBLE //////
    // Every circle-element is a bubble
    bubble = svgContainer.selectAll('circle');

    ////// KEYWORD //////
    keyword = d3.select('#keywordText')
        .text(questionKeyword);

    ////// VOTES TEXT //////
    voteText = svgContainer.selectAll('text');

    /*********
     * FORCE *
     *********/

    // Returns the negative of the radius squared of the node, divided by bubbleDistance:
    // - the negative is for pushing away nodes.
    // - dividing by bubbleDistance scales the repulsion to an appropriate scale for the size of the visualization.
    charge = -Math.pow(bubbleRadius, 2.0) / bubbleDistance;

    /**
     * # d3.layout.force()
     *
     * Constructs a new force-directed layout with the default settings:
     * - size 1×1,
     * - link strength 1,
     * - friction 0.9,
     * - bubbleDistance 20,
     * - charge strength -30,
     * - gravity strength 0.1 and
     * - theta parameter 0.8
     *
     * The default bubblesData and links are the empty array, and when the layout is started,
     * the internal alpha cooling parameter is set to 0.1.
     *
     * The general pattern for constructing force-directed layouts is:
     * - set all the configuration properties and
     * - then call start
     */
    force = d3.layout.force()
        /**
         * # force.nodes([nodes])
         *
         * - If nodes is specified:
         *   sets the layout's associated nodes to the specified array.
         *
         * - If nodes is not specified:
         *   returns the current array, which defaults to the empty array.
         *
         * Each node has the following attributes:
         * - index: the zero-based index of the bubble within the nodes array.
         * - x: the x-coordinate of the current bubble position.
         * - y: the y-coordinate of the current bubble position.
         * - px: the x-coordinate of the previous bubble position.
         * - py: the y-coordinate of the previous bubble position.
         * - fixed: a boolean indicating whether bubble position is locked.
         * - weight: the bubble weight; the number of associated links.
         *
         * These attributes do not need to be set before passing the nodes to the layout;
         * if they are not set, suitable defaults will be initialized by the layout when start is called.
         *
         * However, be aware that if you are storing other data on your nodes, your data attributes should not conflict
         * with the above properties used by the layout.
         */
        .nodes(nodes)
        /**
         * # force.links([links])
         *
         * - If links is specified:
         *   sets the layout's associated links to the specified array
         *
         * - If links is not specified:
         *   returns the current array, which defaults to the empty array.
         *
         * Each link has the following attributes:
         * - source - the source bubble (an element in bubblesData)
         * - target - the target bubble (an element in bubblesData).
         */
        .links([])
        /**
         * # force.gravity([gravity])
         *
         * - If gravity is specified:
         *   sets the gravitational strength to the specified numerical value
         *
         * - If gravity is not specified:
         *   returns the current gravitational strength, which defaults to 0.1.
         *
         * The name of this parameter is perhaps misleading; it does not correspond to physical gravity
         * (which can be simulated using a positive charge parameter).
         *
         * Instead, gravity is implemented as a weak geometric constraint similar to a virtual spring connecting
         * each bubble to the center of the layout's size.
         *
         * This approach has nice properties:
         * - near the center of the layout, the gravitational strength is almost zero,
         *   avoiding any local distortion of the layout;
         *
         * - as bubblesData get pushed farther away from the center, the gravitational strength becomes stronger
         *   in linear proportion to the bubbleDistance.
         *
         * --> Thus, gravity will always overcome repulsive charge forces at some threshold,
         *     preventing disconnected bubblesData from escaping the layout.
         *
         * Gravity can be disabled by setting the gravitational strength to zero.
         * If you disable gravity, it is recommended that you implement some other geometric constraint to prevent bubblesData
         * from escaping the layout, such as constraining them within the layout's bounds.
         */
        .gravity(0)
        /**
         * # force.size([width, height])
         *
         * - If size is specified:
         *   sets the available layout size to the specified two-element array of numbers representing x and y
         *
         * - If size is not specified:
         *   returns the current size, which defaults to [1, 1].
         *
         * The size affects two aspects of the force-directed layout:
         * - the gravitational center:
         *   The center of gravity is simply [ x / 2, y / 2 ].
         *
         * - the initial random position:
         *   When bubblesData are added to the force layout, if they do not have x and y attributes already set,
         *   then these attributes are initialized using a uniform random distribution in the range [0, x] and [0, y],
         *   respectively.
         */
        .size([width, 0])
        /**
         * # force.charge([charge])
         *
         * - If charge is specified:
         *   sets the charge strength to the specified value.
         *
         * - If charge is not specified:
         *   returns the current charge strength, which defaults to -30.
         *
         * - If charge is a constant:
         *   then all nodes have the same charge.
         *
         * - Otherwise, if charge is a function:
         *   then the function is evaluated for each node (in order),
         *   being passed the node and its index, with  this context as the force layout;
         *   the function's return value is then used to set each node's charge.
         *
         * The function is evaluated whenever the layout starts.
         *
         * --> A negative value results in node repulsion, while
         * --> a positive value results in node attraction.
         */
        // The charge in a force layout refers to how nodes in the environment
        // push away from one another or attract one another.
        //
        // Kind of like magnets, nodes have a charge that can be
        // - positive (attraction force)
        // - or negative (repelling force).
        .charge(charge)
        /**
         * # force.on(type, listener)
         *
         * Registers the specified listener to receive events of the specified type from the force layout.
         * Currently, only "start", "tick", and "end" events are supported.
         *
         * The event objects that will be passed to the listener functions are custom objects created using
         * the d3.dispatch() process.
         *
         * Each event object has two properties:
         * - the type (a string, either "start", "tick", or "end"),
         * - and alpha, which is the current value of the alpha cooling parameter (a number between 0 and 1).
         *
         * - The event.alpha property:
         *   can be used to monitor layout progress or to control your own custom adjustments.
         *
         * - The "start" event:
         *   is dispatched both for the initial start of the simulation and anytime the simulation is re-started.
         *
         * - The "tick" events:
         *   are dispatched for each tick of the simulation.
         *   --> Listen to tick events to update the displayed positions of bubblesData and links.
         */
        .on('tick', tick);

    // Check if bubble is dragged
    force.drag()
        .on('dragstart', function () {
            dragging = true;
        })
        .on('dragend', function () {
            dragging = false;
        });


    // Create array to save previous no of votes per answer
    for (i = 0; i < numAnswers; i++) {
        prevNumVotesAnswer[i] = 0;
    }

    updateBubbleViz(ctvData);
}

/**
 * # tick-timer
 *
 * The force layout runs asynchronously.
 * That is, when you call force.start() it starts doing its computations that determine the position of the bubblesData
 * in parallel in the background.
 *
 * These computations are not a single step, but a simulation running over a long time (several seconds).
 *
 * The tick handler is the function that enables you to get the state of the layout when it has changed
 * (the simulation has advanced by a tick) and act on it -- in particular, redraw the bubblesData and links where they
 * currently are in the simulation.
 *
 * You don't have to handle the tick event though, you could simply run the layout for a certain number of steps
 * and then draw without handling the tick event at all, as in this example.
 *
 * Doing it dynamically in the tick handler function has the advantage that you can see how the layout progresses.
 * However, technically it is not needed if you're just interested in the result.
 *
 *
 *
 *
 * */
function tick(e) {

    var k = .1 * e.alpha;

    var spread;

    // Push nodes toward their designated focus.
    nodes.forEach(function (o) {

        // Add slight difference so nodes won't stick together
        spread = Math.random() * 0.1;

        o.x += ((answersCenters[o.parent].x+spread) - o.x ) * k;
        o.y += ((answersCenters[o.parent].y+spread) - o.y ) * k;
    });

    bubble.attr("cx", function (d) {
            return d.x;
        })
        .attr("cy", function (d) {
            return d.y;
        });

    // Update votes texts
    for (i = 0; i < numAnswers; i++) {
        numVotesAnswer[i] = ctvData[i].votesPercent;
        votesTexts[i].votes = numVotesAnswer[i];
        votesTexts[i].x = answersCenters[i].x;
    }

    voteText.text(function (d) {
            return d.votes;
        })
        .attr('x', function (d) {
            return d.x;
        });
}

var visStartCounter = 0;
var scalingCounter = 0;
var draggingCounter = 0;

function updateBubbleViz(data) {

    ctvData = data[1];

    /*********
     * CHART *
     *********/

    ////// CREATE BUBBLES //////
    setInterval(function () {

        // Add bubble for each new vote to corresponding answer
        for (i = 0; i < numAnswers; i++) {

            // Number of votes per answer
            numVotesAnswer[i] = ctvData[i].votes;

            // While their are new votes available...
            while (prevNumVotesAnswer[i] < numVotesAnswer[i]) {

                var answerIndex = answersIndex[i];

                // ...add them to the nodes-Array and give them parent and color attributes
                nodes.push({
                    parent: answerIndex,
                    col: bubbleCols[i]
                });

                //console.log("answerIndex: " + answerIndex);
                prevNumVotesAnswer[i] += 1;

                if (isActive) stateChange();
            }
        }

        /**
         * # force.start()
         *
         * Starts the simulation;
         *
         * This method must be called when the layout is first created, after assigning the bubblesData and links.
         * In addition, it should be called again whenever the bubblesData or links change.
         *
         * Internally, the layout uses a cooling parameter alpha which controls the layout temperature:
         * - As the physical simulation converges on a stable layout, the temperature drops,
         *   causing bubblesData to move more slowly.
         *
         * - Eventually, alpha drops below a threshold and the simulation stops completely,
         *   freeing the CPU and avoiding battery drain.
         *
         * The layout can be reheated using resume or by restarting;
         * this happens automatically when using the drag behavior.
         *
         *
         * On start, the layout initializes various attributes on the associated bubblesData:
         *
         * - The index of each bubble is computed by iterating over the array, starting at zero.
         *
         * - The initial x and y coordinates, if not already set externally to a valid number,
         *   are computed by examining neighboring bubblesData:
         *   If a linked bubble already has an initial position in x or y, the corresponding coordinates
         *   are applied to the new bubble.
         *   --> This increases the stability of the graph layout when new bubblesData are added,
         *       rather than using the default which is to initialize the position randomly within the layout's size.
         *
         * - The previous px and py position is set to the initial position, if not already set,
         *   giving new bubblesData an initial velocity of zero.
         *
         * - Finally, the fixed boolean defaults to false.
         *
         *
         * The layout also initializes the source and target attributes on the associated links:
         * For convenience, these attributes may be specified as a numeric index rather than a direct link,
         * such that the bubblesData and links can be read-in from a JSON file or other static description that may not allow
         * circular linking.
         *
         * The source and target attributes on incoming links are only replaced with the corresponding entries in bubblesData
         * if these attributes are numbers; thus, these attributes on existing links are unaffected when the layout is
         * restarted.
         *
         * The link distances and strengths are also computed on start.
         */
        force.start();

        // Fill bubble with data from nodes-Array
        bubble = bubble.data(nodes);

        // Create new Bubble
        bubble.enter().append('circle')
            .attr('class', '.bubble')
            .attr('cx', function (d) {
                return d.x;
            })
            .attr('cy', function (d) {
                return d.y;
            })
            .attr('r', bubbleRadius)
            .attr('fill', function (d) {
                return d.col;
            })
            .attr('fill-opacity', 0.5)
            .attr('stroke', function (d) {
                return d.col;
            })
            .attr('stroke-width', strokeWidth)
            .call(force.drag);


        voteText = voteText.data(votesTexts);

        voteText.enter().append('text')
            .attr('class', '.voteText')
            .attr('x', function (d) {
                return d.x ;
            })
            .attr('y', (height - (height * 0.1)))
            .text(function (d) {
                return d.votes;
            })
            .attr('font-family', 'Walkway_UltraBold_font')
            .attr('font-size', '2em')
            .style('fill', function(d){
                return d.col;
            })
            // .style('fill', '#746E71')
            .attr('text-anchor', 'middle');


        // If Visualization started wait for 5 seconds to make sure that
        // all the bubbles, which came in at once at Browser-start, stopped
        // bouncing.
        if (!visStart) {
            if (visStartCounter == 10) {
                visStart = true;
                stateChange();
            }
            if (isActive) visStartCounter++;
        }
        if (visStart) {
            // If the isScaling is in progress wait for 5 seconds
            if (isScaling) {
                if (scalingCounter == 50) {
                    isScaling = false;
                    scalingCounter = 0;
                    stateChange();
                }
                if (isActive) scalingCounter++;
            }
            if (dragging) {
                if (draggingCounter == 50) {
                    draggingCounter = 0;
                    stateChange();
                }
                draggingCounter++;
            }
        }

    }, 1000);

    updateCtvData();
}

var count = 0;

// If the visualization doesn't fit to the screen - reduce radius
// and charge of each bubble by 20% max until radius == 5.
function stateChange() {
    nodes.forEach(function (o) {
        if (!dragging && !isScaling && (o.x < ((bubbleRadius / 2) + strokeWidth) || o.x > (width - ((bubbleRadius / 2) + strokeWidth)))) {
            bubbleRadius *= 0.8;
            strokeWidth *= 0.8;
            charge = -Math.pow(bubbleRadius, 2.0) / bubbleDistance;
            force.charge(charge);
            bubble.transition().attr('r', bubbleRadius);
            bubble.attr('stroke-width', strokeWidth);
            isScaling = true;
        }
    });
}
