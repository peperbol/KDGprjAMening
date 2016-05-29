using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Collections.Generic;
using System.Linq;

/// <summary>
/// Queues all questions that are ready to be asked and transfers them to SwipeInput when available to be queues in the scene.
/// </summary>
public class LoadQuestion : MonoBehaviour
{

    public Text questionText;
    public Text projectText;
    public Queue<Question> questions = new Queue<Question>();
    public Material imageMaterial;
    public OverlaySlider loadingScreen;

    //queue to be changed into Question- instancess
    public List<string> ids;

    SwipeInput swipeInput;
    CommentsBuilder commentsBuilder;
    AnswerSender answerSender;
    InstructionAnimation instructionAnimation;
    ToDoHandler todoHandler;

    public bool QuestionsPending { get { return questions.Count > 0 || ids.Count > 0; } }

    void Awake()
    {
        swipeInput = FindObjectOfType<SwipeInput>();
        commentsBuilder = FindObjectOfType<CommentsBuilder>();
        answerSender = FindObjectOfType<AnswerSender>();
        instructionAnimation = FindObjectOfType<InstructionAnimation>();
        todoHandler = FindObjectOfType<ToDoHandler>();
    }
    public void Add(string id)
    {
        ids.Add(id);
        swipeInput.fillQueue(false);
    }
    public void Answer(Question q, bool isLeft)
    {
       if(!DebugActions.loopQuestions) FindObjectOfType<ToDoHandler>().AddAnswered(q.id);
        answerSender.SendAnswer(isLeft, q);

    }
    void QueueIds()
    {
        foreach (var id in ids)
        {
            try
            {
                questions.Enqueue(new Question(id, this));
            }
            catch (System.IO.FileNotFoundException) { Debug.LogWarning("Did not find file of id " + id); }
        }

        if (!DebugActions.loopQuestions) ids.Clear();
    }
    public bool IsQuestionAvailable
    {
        get
        {
            if (questions.Count <= 0) QueueIds();
            return questions.Count > 0;
        }
    }
    public Question NextQuestion(Text left, Text right, Material mat, GameObject obj)
    {
        if (!IsQuestionAvailable)
        {
            return null;
        }
        Question lastQuestion = questions.Dequeue();
        left.text = lastQuestion.leftText;
        right.text = lastQuestion.rightText;
        if (lastQuestion.fullPicture)
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            lastQuestion.GetMainImage(this, e =>
            {
                mat.SetTexture("_MainTex1", e);
                RemoveBootupScreen(obj);
                StartCoroutine(ActivateQuestion(obj));
            });
        }
        else
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            mat.SetTexture("_MainTex2", Texture2D.whiteTexture);
            lastQuestion.GetLeftImage(this, e => mat.SetTexture("_MainTex1", e));
            lastQuestion.GetRightImage(this, e =>
            {
                mat.SetTexture("_MainTex2", e);
                RemoveBootupScreen(obj);
                StartCoroutine(ActivateQuestion(obj));
            });
        }
        return lastQuestion;
    }
    IEnumerator ActivateQuestion(GameObject obj)
    {
        yield return null;
        obj.SetActive(true);
    }
    public void RemoveBootupScreen(GameObject obj)
    {
        if(obj)
        {
            instructionAnimation.Play(obj, !todoHandler.HasEverAnswered);
        }
        loadingScreen.visisble = false;

    }
    public void SetTitle(Question q)
    {
        if (q != null)
        {
            questionText.text = q.questionText;
            projectText.text = q.projectText.ToUpper();
            q.GetComments(this, e =>
            {
                Debug.Log("loaded");
                commentsBuilder.SetComments(e);
            });
            Debug.Log("g");
        }
        else
        {
            questionText.text = projectText.text = "";

            commentsBuilder.SetComments(new Comment[0]);
        }
    }
}
